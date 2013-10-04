<?php
namespace Workflow\Execution\Router;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Di\ServiceLocator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;
use Workflow\Entity\Place;
use Workflow\Entity\Token;
use Workflow\Execution\Router\Exception\ProcessRouterException;
use Workflow\Entity\Transition;
use Workflow\Entity\Arc;

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
		$inputToken = $entityManager->createQuery('SELECT token, token.place, token.place.arcs, token.instance FROM Workflow\Entity\Token token INNER JOIN token.place INNER JOIN token.instance INNER JOIN token.place.arcs WITH arc.direction = :arcDirection WHERE tokenId = :tokenId')
			->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
			->setParameter('tokenId', $token->getId())
			->getSingleResult();
		
		$instance = $inputToken->getInstance();
		$inputPlace = $inputToken->getPlace();
		
		if($inputPlace->getType() == Place::TYPE_END_PLACE) {
			throw new ProcessRouterException('Token sudah berada pada end place, tidak dapat di-route lebih lanjut', 100, null);
		}
		
		$inputArcs = $inputPlace->getArcs();
		$inputArcsCount = count($inputPlace->getArcs());
		
		// Ini tidak valid.
		if($inputArcsCount == 0) {
			throw new ProcessRouterException('Arc dari input place asal dari token yang dirouting tidak ditemukan', 102, null);
		}
		if($inputArcsCount == 1) {
			$inputArc = $inputArcs[0];
			$transition = $entityManager->createQuery('SELECT arc.transition FROM Workflow\Entity\Arc arc INNER JOIN arc.transition WITH arc.id = :arcId INNER JOIN arc.transition.arcs')
				->setParameter('arcId', $inputArc->getId())
				->getSingleResult();
			
			$transitionHandlerName = $transition->getHandler();
			// Setiap transition harus memiliki handler.
			if($transitionHandlerName == null) {
				throw new ProcessRouterException(sprintf('Transition dengan id %s tidak memiliki handler', $transition->getId()), 101, null);
			}
			
			$transitionHandler = $this->serviceLocator->get($transitionHandlerName);
			$transitionHandler->handle($transition);
			
			$transitionRepository = $entityManager->getRepository('Workflow\Entity\Transition');
			$transitionTrigger = $transitionRepository->getTransitionType($transition);
			
			if($transitionTrigger == Transition::TRIGGER_BY_USER) {
				return new RouteResult($success, $message, $code, $fromPlace, $fromToken);
			}
			if($transitionTrigger == Transition::TRIGGER_BY_TIME) {
				
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
				$splitEvaluatorName = $transition->getSplitEvaluator();
				
				// Ini berarti explicit-or-split. Buat token pada place sesuai dengan hasil split evaluator.
				if($splitEvaluatorName != null) {
					$splitEvaluator = $this->serviceLocator->get($splitEvaluatorName);
				
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