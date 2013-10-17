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
use Workflow\Entity\Repository\ArcRepository;
use Workflow\Entity\Repository\WorkitemRepository;
use Application\Common\KeyGeneratorInterface;
use Workflow\Entity\Repository\InstanceRepository;

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
		
		// Ensure token provided in managed state.
		$tokenState = $entityManager->getUnitOfWork()->getEntityState($token);
		if(!($tokenState == UnitOfWork::STATE_MANAGED || $tokenState == UnitOfWork::STATE_DETACHED)) {
			throw new \InvalidArgumentException(sprintf('Parameter object token harus berupa object entity dalam state managed atau detached.'), 100, null);
		}
		
		$inputToken = $token;
		if($tokenState == UnitOfWork::STATE_DETACHED) {
			$inputToken = $entityManager->merge($token);
		}
		
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
		
		/* @var $arcRepository ArcRepository */ 
		$arcRepository = $entityManager->getRepository('Workflow\Entity\Arc');
		$inputArcs = $arcRepository->getInputArcsFrom($inputPlace);
		$inputArcsCount = $arcRepository->countInputArcsFrom($inputPlace);
		
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
			
			$transition = $inputArc->getTransition();
			if($transition->getHandler() == null) {
				throw new ProcessRouterException(
					sprintf(
						'Transition (id %d, workflow id %d) tidak memiliki handler, setiap transition harus memiliki handler', 
						$transition->getId(),
						$instance->getWorkflow()->getId()
					), 103, null);
			}
			
			/* @var $transitionHandler TransitionHandler */
			$transitionHandler = $this->serviceLocator->get($transition->getHandler());
			$transitionHandler->handle($transition, $instance);
			
			/* @var $transitionRepository TransitionRepository */
			$transitionRepository = $entityManager->getRepository('Workflow\Entity\Transition');
			
			// Benerin ini.
			$transitionTrigger = $transitionRepository->getTransitionTriggerType($transition);
			
			if($transitionTrigger == Transition::TRIGGER_BY_USER) {
				/* @var $workitemRepository WorkitemRepository */ 
				$workitemRepository = $entityManager->getRepository('Workflow\Entity\Workitem');
				if($workitemRepository->hasEnabledWorkitem($instance, $transition)) {
					return new RouteResult(false, null, RouteResult::WAIT_USER_TRANSITION_CODE, $inputPlace, $inputToken);
				}
			}
			else if($transitionTrigger == Transition::TRIGGER_BY_TIME) {
				
			}
			else if($transitionTrigger == Transition::TRIGGER_BY_AUTO) {
				
			}
			else if($transitionTrigger == Transition::TRIGGER_BY_MESSAGE) {
				
			}
			else {
				throw new ProcessRouterException(sprintf('Jenis transition trigger %s tidak valid', $transitionTrigger), 100, null);
			}
			
			$outputArcs = $arcRepository->getOutputArcsFrom($transition);
			$outputArcsCount = $arcRepository->countOutputArcsFrom($transition);
			
			if($outputArcsCount == 0) {
				throw new ProcessRouterException(sprintf('Arc dari transition (id : %s) ke output place tidak ditemukan.', $transition->getId()), 103, null);
			}
			else if($outputArcsCount == 1) {
				/* @var $outputArc Arc */
				$outputArc = $outputArcs[0];
				$outputPlace = $outputArc->getPlace();
				
				/* @var $keyGenerator KeyGeneratorInterface */ 
				$keyGenerator = $this->serviceLocator->get('Application\Common\KeyGeneratator');
				
				$entityManager->beginTransaction();
				try {
					// Create free token pada output place.
					$outputToken = new Token();
					$outputToken->setId($keyGenerator->generateNextKey($outputToken, 'id'));
					$outputToken->setInstance($instance);
					$outputToken->setPlace($outputPlace);
					$outputToken->setEnabledDate(new \DateTime(null, null));
					$outputToken->setStatus(Token::STATUS_FREE);
					$entityManager->persist($outputToken);
					$entityManager->flush($outputToken);
					
					// Consume free token pada input token.
					$inputToken->setStatus(Token::STATUS_CONSUMED);
					$entityManager->persist($inputToken);
					$entityManager->flush($inputToken);
					
					$entityManager->commit();
					
					$outputPlaces = array();
					$outputPlaces[] = $outputPlace;
					
					$outputTokens = array();
					$outputTokens[] = $outputToken;
					return new RouteResult(true, null, -1, $inputPlace, $inputToken, $transition, $outputPlaces, $outputTokens);
				}
				catch (\Exception $e) {
					$entityManager->rollback();
					throw new ProcessRouterException('Route proses gagal, terjadi eksepsi, perhatikan stack trace eksepsi', 100, $e);
				}
			}
			else if($outputArcsCount > 1) {
				// Ini berarti explicit-or-split. Buat token pada place sesuai dengan hasil split evaluator.
				if($transition->getSplitEvaluator() != null) {
					/* @var $splitEvaluator SplitEvaluatorInterface */
					$splitEvaluator = $this->serviceLocator->get($transition->getSplitEvaluator());
				
					/* @var $instanceRepository InstanceRepository */ 
					$instanceRepository = $entityManager->getRepository('Workflow\Entity\Instance');
					$instanceDatas = $instanceRepository->getInstanceDatas($instance);
					
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
				/**
				 * @TODO Sempurnakan bagian ini.
				 */
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
		/**
		 * @TODO Sempurnakan bagian ini
		 */
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