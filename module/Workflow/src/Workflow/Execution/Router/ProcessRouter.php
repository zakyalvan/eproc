<?php
namespace Workflow\Execution\Router;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;
use Workflow\Entity\Place;
use Workflow\Entity\Token;
use Workflow\Execution\Router\Exception\ProcessRouterException;
use Workflow\Entity\Transition;
use Workflow\Entity\Arc;
use Workflow\Execution\Handler\TransitionHandler;
use Workflow\Entity\Instance;
use Workflow\Entity\Repository\TransitionRepository;
use Workflow\Execution\Evaluator\SplitEvaluatorInterface;

/**
 * Implementasi default dari {@link ProcessRouterInterface}
 * 
 * @author zakyalvan
 */
class ProcessRouter implements ProcessRouterInterface, ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function routeToNextPlaces(Token $token) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		/* @var $inputToken Token */
		$inputToken = $entityManager->createQuery('SELECT token, instance, workflow, place, arcs FROM Workflow\Entity\Token token INNER JOIN token.place place INNER JOIN token.instance instance INNER JOIN instance.workflow workflow INNER JOIN place.arcs arcs WITH arcs.direction = :arcDirection WHERE token.id = :tokenId')
			->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
			->setParameter('tokenId', $token->getId())
			->getSingleResult();
		
		// Jika status token sudah tidak free.
		if($inputToken->getStatus() !== Token::STATUS_FREE) {
			throw new ProcessRouterException(
				sprintf(
					'Token (id %s, workflow-id %s, instance-id %s, place-id %s) tidak dapat diroute karena statusnya sudah tidak free (atau sudah di-consume atau di-cancel sebelumnya)', 
					$inputToken->getId(), 
					$inputToken->getInstance()->getWorkflow()->getId(),
					$inputToken->getInstance()->getId(), 
					$inputToken->getPlace()->getId()
				), 100, null);
		}
		
		/* @var $instance Instance */
		$instance = $inputToken->getInstance();
		
		/* @var $inputPlace Place */
		$inputPlace = $inputToken->getPlace();
		
		if($inputPlace->getType() == Place::TYPE_END_PLACE) {
			throw new ProcessRouterException(
				sprintf(
					'Token (id %s, workflow-id %s, instance-id %s, place-id %s) sudah berada pada end place, tidak dapat di-route lebih lanjut',
					$inputToken->getId(),
					$inputToken->getInstance()->getWorkflow()->getId(),
					$inputToken->getInstance()->getId(),
					$inputToken->getPlace()->getId()
				), 101, null);
		}
		
		$inputArcs = $inputPlace->getArcs();
		$inputArcsCount = count($inputPlace->getArcs());
		
		// Ini tidak valid karena hanya and place yang tidak punya input-arc.
		if($inputArcsCount == 0) {
			throw new ProcessRouterException(
				sprintf(
					'Input arc dari input place (id %s, workflow-id %s) di mana token (id %s, workflow-id %s, instance-id %s, place-id %s) yang dirouting berada tidak ditemukan',
					$inputPlace->getId(),
					$instance->getWorkflow()->getId(),
					$inputToken->getId(),
					$instance->getWorkflow()->getId(),
					$instance->getId(),
					$inputToken->getPlace()->getId()
				), 102, null);
		}
		// Ini jika hanya ada satu arc yang keluar dari input place.
		else if($inputArcsCount == 1) {
			/* @var $inputArc Arc */
			$inputArc = $inputArcs[0];
			
			/* @var $transition Transition */
			$transition = $entityManager->createQuery('SELECT transition FROM Workflow\Entity\Transition transition INNER JOIN transition.arcs arcs WITH arcs.id = :arcId AND arcs.direction = :arcDirection')
				->setParameter('arcId', $inputArc->getId())
				->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
				->getSingleResult();
			
			if($transition->getHandler() == null) {
				throw new ProcessRouterException(
					sprintf(
						'Transition (id %s, workflow id %s) tidak memiliki handler, setiap transition harus memiliki handler', 
						$transition->getId(),
						$instance->getWorkflow()->getId()
					), 103, null);
			}
			
			/* @var $transitionHandler TransitionHandler */
			$transitionHandler = $this->serviceLocator->get($transition->getHandler());
			$transitionHandler->handle($transition, $instance);
			
			/* @var $transitionRepository TransitionRepository */
			$transitionRepository = $entityManager->getRepository('Workflow\Entity\Transition');
			$transitionTrigger = $transitionRepository->getTransitionTriggerType($transition);
			
			if($transitionTrigger == Transition::TRIGGER_BY_USER) {
				return new RouteResult($success, $message, $code, $fromPlace, $fromToken);
			}
			else if($transitionTrigger == Transition::TRIGGER_BY_TIME) {
				
			}
			
			$outputArcs = $transition->getArcs();
			$outputArcsCount = count($outputArcs);
			
			if($outputArcsCount == 0) {
				throw new ProcessRouterException(sprintf('Arc dari transition (id : %s) ke output place tidak ditemukan.', $transition->getId()), 103, null);
			}
			else if($outputArcsCount == 1) {
				$outputArc = $outputArcs[0];
				$outputPlace = $entityManager->createQuery('SELECT arc.place FROM Workflow\Entity\Arc arc INNER JOIN arc.place WITH arc.id = :arcId AND arc.direction = :placeType')
					->setParameter('arcId', $arc->getId())
					->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
					->getSingleResult();
				
				// Create token pada output place.
				$outputToken = new Token();
				$outputToken->setInstance($instance);
				$outputToken->setPlace($outputPlace);
				$outputToken->setEnabledDate($now);
				$entityManager->persist($outputToken);
				
				$outputPlaces = array();
				$outputPlaces[] = $outputPlace;
				
				$outputTokens = array();
				$outputTokens[] = $outputToken;
				return new RouteResult(true, null, -1, $inputPlace, $inputToken, $transition, $outputPlaces, $outputTokens);
			}
			else if($outputArcsCount > 1) {
				// Ini berarti explicit-or-split. Buat token pada place sesuai dengan hasil split evaluator.
				if($transition->getSplitEvaluator() != null) {
					/* @var $splitEvaluator SplitEvaluatorInterface */
					$splitEvaluator = $this->serviceLocator->get($transition->getSplitEvaluator());
				
					$instanceDatasArray = array();
					$instanceDatas = $instance->getDatas();
					foreach ($instanceDatas as $instanceData) {
						// Masukin instance data ke array.
					}
				
					$splitEvaluator->setDatas($instanceDatasArray);
					$splitEvaluatorResult = $splitEvaluator->evaluate();
				
					$outputArc = $entityManager->createQuery('SELECT arc, arc.place FROM Worflow\Entity\Arc arc INNER JOIN arc.place INNER JOIN arc.transition WITH arc.transition.id = :transitionId WHERE arc.direction = :arcDirection AND arc.label = :arcLabel')
						->setParameter('transitionId', $transition->getId())
						->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
						->setParameter('arcLabel', $splitEvaluatorResult)
						->getSingleResult();
				
					$outputPlace = $outputArc->getPlace();
				
					// Create token pada output place.
					$newToken = new Token();
					$newToken->setInstance($instance);
					$newToken->setPlace($outputPlace);
					$newToken->setEnabledDate($now);
					$entityManager->persist($newToken);
				
					$outputPlaces = array();
					$outputPlaces[] = $outputPlace;
					
					$outputTokens = array();
					$outputTokens[] = $newToken;
					return new RouteResult(true, null, -1, $inputPlace, $inputToken, $transition, $outputPlaces, $outputTokens);
				}
				// Ini berarti and-split. Buat token baru pada seluruh output place.
				else {
					$outputPlaces = array();
					$outputTokens = array();
					
					foreach ($outputArcs as $outputArc) {
						$outputPlace = $outputArc->getPlace();
						
						// Create token pada output place.
						$newToken = new Token();
						$newToken->setInstance($instance);
						$newToken->setPlace($outputPlace);
						$newToken->setEnabledDate($now);
						$entityManager->persist($newToken);
						
						$outputPlaces[] = $outputPlaces;
						$outputTokens[] = $newToken;
					}
					
					return new RouteResult(true, null, -1, $inputPlace, $inputToken, $transition, $outputPlaces, $outputTokens);
				}
			}
		}
		else if($inputArcsCount > 1) {
			// Pastikan dulu bahwa (sudah tidak ada) transition yang menunggu.
			
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAware::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAware::getServiceLocator()
	 */
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}