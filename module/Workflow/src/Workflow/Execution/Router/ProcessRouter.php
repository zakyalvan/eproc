<?php
namespace Workflow\Execution\Router;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\EventManager\EventManagerAwareInterface as EventManagerAware;
use Zend\EventManager\EventManagerInterface as EventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;
use Application\Common\KeyGeneratorInterface;
use Workflow\Execution\Evaluator\SplitEvaluatorInterface;
use Workflow\Execution\Router\Exception\ProcessRouterException;
use Workflow\Execution\Router\Event\WorkitemEvent;
use Workflow\Execution\Handler\TransitionHandler;
use Workflow\Entity\Place;
use Workflow\Entity\Token;
use Workflow\Entity\Transition;
use Workflow\Entity\Arc;
use Workflow\Entity\Instance;
use Workflow\Entity\Workitem;
use Workflow\Entity\Repository\TransitionRepository;
use Workflow\Entity\Repository\ArcRepository;
use Workflow\Entity\Repository\WorkitemRepository;
use Workflow\Entity\Repository\InstanceRepository;
use Workflow\Entity\Repository\TokenRepository;

/**
 * Implementasi default dari {@link ProcessRouterInterface}
 * 
 * @author zakyalvan
 */
class ProcessRouter implements ProcessRouterInterface, ServiceLocatorAware, EventManagerAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * @var EventManager
	 */
	private $eventManager;
	
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
					'Token (id %d, workflow-id %s, instance-id %d, place-id %d) tidak dapat diroute karena statusnya sudah tidak free (atau sudah di-consume atau di-cancel sebelumnya)', 
					$inputToken->getId(), 
					$inputToken->getInstance()->getWorkflow()->getId(),
					$inputToken->getInstance()->getId(), 
					$inputToken->getPlace()->getId()
				), 100, null);
		}
		
		/* @var $instance Instance */
		$instance = $inputToken->getInstance();
		
		/* @var $instanceRepository InstanceRepository */
		$instanceRepository = $entityManager->getRepository('Workflow\Entity\Instance');
		
		/* @var $inputPlace Place */
		$inputPlace = $inputToken->getPlace();
		
		if($inputPlace->getType() == Place::TYPE_END_PLACE) {
			return new RouteResult(false, 'Token sudah berada pada end place, tidak mungkin di route lebih lanjut', RouteResult::TOKEN_ON_END_PLACE_CODE, $inputPlace, $inputToken);
		}
		
		/* @var $arcRepository ArcRepository */ 
		$arcRepository = $entityManager->getRepository('Workflow\Entity\Arc');
		$inputArcs = $arcRepository->getInputArcsFrom($inputPlace);
		$inputArcsCount = $arcRepository->countInputArcsFrom($inputPlace);
		
		// Ini tidak valid karena hanya end place yang tidak punya input-arc (arc dri place ke transition).
		if($inputArcsCount == 0) {
			throw new ProcessRouterException(
				sprintf(
					'Input arc dari input place (id %d, workflow-id %s) di mana token (id %d, workflow-id %s, instance-id %d, place-id %d) yang dirouting berada tidak ditemukan',
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
			
			/* @var $transitionRepository TransitionRepository */
			$transitionRepository = $entityManager->getRepository('Workflow\Entity\Transition');
			$transitionTrigger = $transitionRepository->getTransitionTriggerType($transition);
			
			if($transitionTrigger == Transition::TRIGGER_BY_USER) {
				/* @var $tokenRepository TokenRepository */ 
				$tokenRepository = $entityManager->getRepository('Workflow\Entity\Token');
				
				// Karena cuma ada satu arc yang masuk, tidak perlu iterasi untuk hitung jumlah token yang pernah dibuat.
				$tokenCount = $tokenRepository->countToken($instance, $inputPlace);
				
				/* @var $workitemRepository WorkitemRepository */ 
				$workitemRepository = $entityManager->getRepository('Workflow\Entity\Workitem');
				$workitemCount = $workitemRepository->countWorkitem($instance, $transition);
				
				if($tokenCount > $workitemCount) {
					$workitem = new Workitem();
					$workitem->setId($this->keyGenerator()->generateNextKey($workitem, 'id'));
					$workitem->setInstance($instance);
					$workitem->setTransition($transition);
					$workitem->setStatus(Workitem::STATUS_ENABLED);
					$workitem->setEnabledDate(new \DateTime(null, null));

					$workitemEvent = new WorkitemEvent();
					$workitemEvent->setName(WorkitemEvent::WORKITEM_PRE_ASSIGN);
					$workitemEvent->setTarget($this);
					$workitemEvent->setWorkflow($transition->getWorkflow());
					$workitemEvent->setTransition($transition);
					$workitemEvent->setInstance($instance);
					$workitemEvent->setWorkitem($workitem);	
					$workitemEvent->setInstanceDatas($instanceRepository->getInstanceDatas($instance));
					
					$this->eventManager->trigger($workitemEvent);
					
					$workitem = $entityManager->merge($workitem);
					$entityManager->flush($workitem);
					
					$workitemEvent->setName(WorkitemEvent::WORKITEM_POST_ASSIGN);
					$workitemEvent->setWorkitem($workitem);
					$this->eventManager->trigger($workitemEvent);
					
					return new RouteResult(false, 'Menunggu transisi oleh user ditrigger.', RouteResult::WAIT_USER_TRANSITION_CODE, $inputPlace, $inputToken);
				}
				else if($tokenCount == $workitemCount) {
					if($workitemRepository->hasEnabledWorkitem($instance, $transition)) {
						return new RouteResult(false, 'Menunggu transisi oleh user ditrigger.', RouteResult::WAIT_USER_TRANSITION_CODE, $inputPlace, $inputToken);
					}
				}
				else {
					throw new ProcessRouterException('Tidak mungkin jumlah workitem (%d) lebih besar dari jumlah seluruh token pada masing-masing input place sebuah (user) transition', 108, null);
				}
			}
			else if($transitionTrigger == Transition::TRIGGER_BY_TIME) {
				/**
				 * @TODO Implement
				 */
			}
			else if($transitionTrigger == Transition::TRIGGER_BY_AUTO) {
				/**
				 * @TODO Implement
				 */
			}
			else if($transitionTrigger == Transition::TRIGGER_BY_MESSAGE) {
				/**
				 * @TODO Implement
				 */
			}
			else {
				throw new ProcessRouterException(
					sprintf('
						Jenis transition trigger %s tidak valid', 
						$transitionTrigger
					), 100, null);
			}
			
			$outputArcs = $arcRepository->getOutputArcsFrom($transition);
			$outputArcsCount = $arcRepository->countOutputArcsFrom($transition);
			
			if($outputArcsCount == 0) {
				throw new ProcessRouterException(
					sprintf(
						'Output arc dari transition (id : %d, workflow-id : %s) ke output place(s) tidak ditemukan satupun.', 
						$transition->getId(),
						$transition->getWorkflow()->getId()
					), 103, null);
			}
			else if($outputArcsCount == 1) {
				/* @var $outputArc Arc */
				$outputArc = $outputArcs[0];
				$outputPlace = $outputArc->getPlace();
				
				$entityManager->beginTransaction();
				try {
					// Create free token pada output place.
					$outputToken = new Token();
					$outputToken->setId($this->keyGenerator()->generateNextKey($outputToken, 'id'));
					$outputToken->setInstance($instance);
					$outputToken->setPlace($outputPlace);
					$outputToken->setEnabledDate(new \DateTime(null, null));
					$outputToken->setStatus(Token::STATUS_FREE);
					$entityManager->persist($outputToken);
					
					// Consume free token pada input token.
					$inputToken->setStatus(Token::STATUS_CONSUMED);
					$inputToken->setConsumedDate(new \DateTime(null, null));
					$entityManager->persist($inputToken);
					
					// Jika token sudah berada pada end place, akhiri status instance.
					if($outputPlace->getType() == Place::TYPE_END_PLACE) {
						$instance->setStatus(Instance::STATUS_FINISHED);
						$instance->setFinishDate(new \DateTime(null, null));
						$instance = $entityManager->merge($instance);
					}
					
					$entityManager->flush();
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
				
					$instanceDatas = $instanceRepository->getInstanceDatas($instance);
					
					$splitEvaluator->setDatas($instanceDatas);
					$splitEvaluatorResult = $splitEvaluator->evaluate();
				
					$outputArc = $arcRepository->getOutputArcByLabelFrom($transition, $splitEvaluatorResult);

					$outputPlace = $outputArc->getPlace();
					
					$entityManager->beginTransaction();
					try {
						// Create token pada output place.
						$outputToken = new Token();
						$outputToken->setId($this->keyGenerator()->generateNextKey($outputToken, 'id'));
						$outputToken->setInstance($instance);
						$outputToken->setPlace($outputPlace);
						$outputToken->setStatus(Token::STATUS_FREE);
						$outputToken->setEnabledDate(new \DateTime(null, null));
						$entityManager->persist($outputToken);
						
						// Consume free token pada input token sebelumnya.
						$inputToken->setStatus(Token::STATUS_CONSUMED);
						$inputToken->setConsumedDate(new \DateTime(null, null));
						$entityManager->persist($inputToken);
						
						$entityManager->flush();
						$entityManager->commit();
						
						$outputPlaces = array(
							$outputPlace
						);						
						$outputTokens = array(
							$outputToken
						);
						return new RouteResult(true, null, -1, $inputPlace, $inputToken, $transition, $outputPlaces, $outputTokens);
					}
					catch (\Exception $e) {
						$entityManager->rollback();
						throw new ProcessRouterException('Proses routing gagal, eksepsi terjadi, silahkan perhatikan stack trace eksepsi', 100, $e);
					}
				}
				// Ini berarti and-split. Buat token baru pada seluruh output place.
				else {
					try {
						$outputPlaces = array();
						$outputTokens = array();
						
						foreach ($outputArcs as $outputArc) {
							$outputPlace = $outputArc->getPlace();
							
							// Create token pada output place.
							$outputToken = new Token();
							$outputToken->setId($this->keyGenerator()->generateNextKey($outputToken, 'id'));
							$outputToken->setInstance($instance);
							$outputToken->setPlace($outputPlace);
							$outputToken->setStatus(Token::STATUS_FREE);
							$outputToken->setEnabledDate(new \DateTime(null, null));
							$entityManager->persist($outputToken);
							
							$outputPlaces[] = $outputPlaces;
							$outputTokens[] = $outputToken;
						}
						
						// Consume free token pada input token sebelumnya.
						$inputToken->setStatus(Token::STATUS_CONSUMED);
						$inputToken->setConsumedDate(new \DateTime(null, null));
						$entityManager->persist($inputToken);
						
						$entityManager->flush();
						$entityManager->commit();
						
						return new RouteResult(true, null, -1, $inputPlace, $inputToken, $transition, $outputPlaces, $outputTokens);
					}
					catch(\Exception $e) {
						$entityManager->rollback();
						throw new ProcessRouterException('Proses routing gagal, eksepsi terjadi, silahkan perhatikan stack trace eksepsi', 100, $e);
					}
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
	 * Retrieve key generator.
	 * 
	 * @return KeyGeneratorInterface
	 */
	protected function keyGenerator() {
		return $this->serviceLocator->get('Application\Common\KeyGeneratator');
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
	/**
	 * (non-PHPdoc)
	 * @see \Zend\EventManager\EventManagerAwareInterface::setEventManager()
	 */
	public function setEventManager(EventManager $eventManager) {
		$eventManager->setIdentifiers(array(
			get_called_class()
		));
		$this->eventManager = $eventManager;
	}
	
	public function getEventManager() {
		return $this->eventManager;
	}
}