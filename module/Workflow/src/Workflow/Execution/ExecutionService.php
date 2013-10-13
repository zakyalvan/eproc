<?php
namespace Workflow\Execution;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Json\Json;
use Doctrine\ORM\EntityManager;
use Application\Common\KeyGeneratorInterface;
use Workflow\Execution\Router\ProcessRouterInterface as ProcessRouter;
use Workflow\Execution\Router\RouteResult;
use Workflow\Entity\Instance;
use Workflow\Entity\Place;
use Workflow\Entity\Workflow;
use Workflow\Entity\Token;
use Workflow\Entity\WorkflowAttribute;
use Workflow\Entity\InstanceData;
use Workflow\Entity\Workitem;
use Workflow\Entity\Repository\WorkitemRepository;
use Workflow\Entity\Repository\TransitionRepository;
use Workflow\Entity\Repository\InstanceRepository;
use Workflow\Entity\Repository\PlaceRepository;
use Workflow\Entity\Repository\TokenRepository;
use Doctrine\ORM\UnitOfWork;
use Workflow\Entity\Repository\WorkflowRepository;

/**
 * Implementasi default dari ExecutionServiceInterface
 * 
 * @author zakyalvan
 */
class ExecutionService implements ExecutionServiceInterface, ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Manager\InstanceManagerInterface::canStartWorkflow()
	 */
	public function canStartWorkflow(Workflow $workflow, array $datas) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Manager\InstanceManagerInterface::startWorkflow()
	 */
	public function startWorkflow(Workflow $workflow, array $datas) {
		if(!($workflow != null && $workflow->getId() != null)) {
			throw new \InvalidArgumentException('Parameter workflow yang diberikan tidak valid', 100, null);
		}
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		/* @var $keyGenerator KeyGeneratatorInterface */ 
		$keyGenerator = $this->serviceLocator->get('Application\Common\KeyGeneratator');
		
		// Start transaksi.
		$entityManager->beginTransaction();
		try {
			if($persitedWorkflow == null) {
				$workflow = $entityManager->merge($workflow);
			}
			else {
				$workflow = $persitedWorkflow;
			}
			
			/* @var $instanceRepository InstanceRepository */ 
			$instanceRepository = $entityManager->getRepository('Workflow\Entity\Instance');
			$instance = $instanceRepository->createNewInstance($workflow);
			$instance->setId($keyGenerator->generateNextKey($instance, 'id'));
			$instanceRepository->setInstanceDatas($instance, $datas);
			
			/* @var $placeRepository PlaceRepository */
			$placeRepository = $entityManager->getRepository('Workflow\Entity\Place');
			$startPlace = $placeRepository->getStartPlace($workflow);
			
			/* @var $tokenRepository TokenRepository */ 
			$tokenRepository = $entityManager->getRepository('Workflow\Entity\Token');
			$token = $tokenRepository->createFreeToken($instance, $startPlace);
			
			// Route token to next place.
			$this->routeTokenToNextPlace($token);
			
			// Flush perubahan dan commit transaksi.
			$entityManager->flush();
			$entityManager->commit();
			
			return $instance;
		}
		catch (\Exception $e) {
			// Rollback transaksi karena terjadi eksepsi.
			$entityManager->rollback();
			throw new \RuntimeException('Terjadi kesalahan dalam proses start workflow instance. Silahkan perhatikan trace exception.', 100, $e);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\ExecutionServiceInterface::getActiveInstances()
	 */
	public function getActiveInstances(Workflow $workflow, $datas = array()) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		if($datas) {
			/* @var $workflowRepository WorkflowRepository */ 
			$workflowRepository = $entityManager->getRepository('Workflow\Entity\Workflow');
			
			// Cek apakah key datas yang diberikan merupakan attribute workflow yang valid atau tidak. Exception jika tidak valid.
			$workflowRepository->isValidWorkflowAttributes($workflow, array_keys($datas), true);
		}
		
		/* @var $instanceRepository InstanceRepository */
		$instanceRepository = $entityManager->getRepository('Workflow\Entity\Instance');
		$instanceRepository->getActiveInstances($workflow, $datas);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\ExecutionServiceInterface::canExecuteWorkitem()
	 */
	public function canExecuteWorkitem(Workitem $workitem, array $datas, $userContext, $userRole, $userId) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		// Untuk sementara, object workitem harus dalam state managed atau detached dalam entity-manager.
		$workitemState = $entityManager->getUnitOfWork()->getEntityState($workitem);
		if($workitemState !== UnitOfWork::STATE_MANAGED || $workitemState !== UnitOfWork::STATE_DETACHED) {
			throw new \InvalidArgumentException(sprintf('Tidak dapat mengeksekusi workitem yang diberikan. Object workitem harus dalam state managed atau detached dalam entity-manager.'), 100, null);
		}
		/* @var $workitem Workitem */
		$workitem = $entityManager->merge($workitem);
		
		/* @var $workitemRepository WorkitemRepository */
		$workitemRepository = $entityManager->getRepository('Workflow\Entity\Workitem');
				
		if(!$workitemRepository->isValidWorkitemExecutor($workitem, $userContext, $userId, $userRole)) {
			throw new \InvalidArgumentException(sprintf('Tidak dapat mengeksekusi workitem yang diberikan. User yang diberikan bukan user yang dapat mengeksekusi workitem tersebut,'), 100, null);
		}
				
		if(!$workitemRepository->isEnabledWorkitem($workitem)) {
			throw new \InvalidArgumentException(sprintf('Workitem sudah dieksekusi sebelumnya, tidak dapat mengeksekusi workitem yang diberikan'), 100, null);
		}
		
		/* @var $transitionRepository TransitionRepository */
		$transitionRepository = $entityManager->getRepository('Workflow\Entity\Transition');
		$transitionAttributes = $transitionRepository->getTransitionAttributes($workitem->getTransition(), $workitem->getTransition()->getWorkflow());
				
		foreach ($transitionAttributes as $transitionAttribute) {
			if(!array_key_exists($transitionAttribute, $datas)) {
				throw new \InvalidArgumentException(sprintf('Transition attribute %s yang dibutuhkan untuk mengeksekusi workitem belum diberikan dalam parameter datas', $transitionAttribute), 100, null);
			}
		}
		return true;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\ExecutionServiceInterface::executeWorkitem()
	 */
	public function executeWorkitem(Workitem $workitem, array $datas, $userContext, $userRole, $userId) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$entityManager->beginTransaction();
		try {
			// Untuk sementara, object workitem harus dalam state managed atau detached dalam entity-manager.
			$workitemState = $entityManager->getUnitOfWork()->getEntityState($workitem);
			if($workitemState !== UnitOfWork::STATE_MANAGED || $workitemState !== UnitOfWork::STATE_DETACHED) {
				throw new \InvalidArgumentException(sprintf('Tidak dapat mengeksekusi workitem yang diberikan. Object workitem harus dalam state managed atau detached dalam entity-manager.'), 100, null);
			}
			/* @var $workitem Workitem */
			$workitem = $entityManager->merge($workitem);
		
			/* @var $workitemRepository WorkitemRepository */
			$workitemRepository = $entityManager->getRepository('Workflow\Entity\Workitem');
			
			if(!$workitemRepository->isValidWorkitemExecutor($workitem, $userContext, $userId, $userRole)) {
				throw new \InvalidArgumentException(sprintf('Tidak dapat mengeksekusi workitem yang diberikan. User yang diberikan bukan user yang dapat mengeksekusi workitem tersebut,'), 100, null);
			}
			
			if(!$workitemRepository->isEnabledWorkitem($workitem)) {
				throw new \InvalidArgumentException(sprintf('Workitem sudah dieksekusi sebelumnya, tidak dapat mengeksekusi workitem yang diberikan'), 100, null);
			}

			/* @var $transitionRepository TransitionRepository */
			$transitionRepository = $entityManager->getRepository('Workflow\Entity\Transition');
			$transitionAttributes = $transitionRepository->getTransitionAttributes($workitem->getTransition(), $workitem->getTransition()->getWorkflow());
			
			foreach ($transitionAttributes as $transitionAttribute) {
				if(!array_key_exists($transitionAttribute, $datas)) {
					throw new \InvalidArgumentException(sprintf('Transition attribute %s yang dibutuhkan untuk mengeksekusi workitem belum diberikan dalam parameter datas', $transitionAttribute), 100, null);
				}
			}
			
			/* @var $instanceRepository InstanceRepository */
			$instanceRepository = $entityManager->getRepository('Workflow\Entity\Instance');
			$instanceRepository->setInstanceDatas($workitem->getInstance(), $datas);
			
			// Ubah status workitem.
			$workitem->setStatus(Workitem::STATUS_FINISHED);
			$entityManager->persist($workitem);
			
			/* @var $placeRepository PlaceRepository */ 
			$placeRepository = $entityManager->getRepository('Workflow\Entity\Place');
			$inputPlaces = $placeRepository->getInputPlaces($workitem->getTransition(), $workitem->getTransition()->getWorkflow());
			
			/* @var $tokenRepository TokenRepository */
			$tokenRepository = $entityManager->getRepository('Workflow\Entity\Token');
			
			$freeTokens = array();
			foreach ($inputPlaces as $inputPlace) {
				/* @var $inputPlace Place */
				if($tokenRepository->hasFreeToken($instance, $inputPlace)) {
					$freeTokensToRoute[] = $tokenRepository->getFreeToken($instance, $inputPlace);
				}
			}
			
			if(count($freeTokens) == 0) {
				throw new \RuntimeException(sprintf('Eksekusi workitem gagal. Tidak ditemukan free token(s) pada input place untuk transisi dari instance'), 100, null);
			}
			if(count($freeTokens) > 1) {
				throw new \RuntimeException(sprintf('Sementara belum dapat menghandle dua token pada lebih dari satu input place'), 100, null);
			}
			
			// Sementara hanya bisa route dari satu free token.
			$this->routeTokenToNextPlace($freeTokens[0]);
			
			$entityManager->flush();
			$entityManager->commit();
		}
		catch(\Exception $e) {
			$entityManager->rollback();
			throw new \RuntimeException(sprintf('Proses eksekusi workitem dengan identity %s gagal, terjadi eksepsi internal database', Json::encode($workitemIdentity)), 100, null);
		}
	}
	
	/**
	 * Route token to next place.
	 *
	 * @param Token $token
	 */
	protected function routeTokenToNextPlace(Token $token) {
		/* @var $processRouter ProcessRouter */
		$processRouter = $this->serviceLocator->get('Workflow\Execution\Router\ProcessRouter');
	
		$routeSuccess = true;
		$tokenToRoute = $token;
	
		// Sekarang waktunya route token sampain proses routing gagal/berhenti.
		while($routeSuccess) {
			$result = $this->processRouter->routeToNextPlace($tokenToRoute);
	
			if($result->isSuccess()) {
				$nextTokensCount = count($result->getNextTokens());
				if($nextTokensCount == 1) {
					$nextTokens = $result->getNextTokens();
					$tokenToRoute = $nextTokens[0];
				}
				else if($nextTokensCount < 1) {
					throw new \RuntimeException("Jumlah proses next token setelah proses routing < 1, ini aneh.", 0, null);
				}
				else if($nextTokensCount > 1) {
					throw new \RuntimeException("Belum bisa handle percabangan pada transisi (dua free token pada satu instance setelah proses routing)");
				}
			}
			else {
				$routeSuccess = false;
				if($result->getCode() == RouteResult::EXCEPTION_ON_ROUTING_CODE) {
					// Lempar kembali exception dari proses routing.
					throw $result->getException();
				}
			}
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\ExecutionServiceInterface::isCompletedInstance()
	 */
	public function isCompletedInstance(Instance $instance) {
		/* @var $instanceRepository InstanceRepository */ 
		$instanceRepository = $this->serviceLocator->get('Doctrine\ORM\EntityManager')->getRepository('Workflow\Entity\Instance');
		$instanceRepository->isFinishedInstance($instance, $instance->getWorkflow());
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Manager\InstanceManagerInterface::getWorkflowState()
	 */
	public function getInstanceState(Instance $instance) {
		return $this->entityManager
			->createQuery('SELECT token.place FROM Workflow\Entity\Token AS token INNER JOIN token.place INNER JOIN token.instance WITH token.instance.id = :instanceId')
			->setParameter('instanceId', $instance->getId())
			->getResult();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
	 */
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}