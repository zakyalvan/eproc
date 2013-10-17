<?php
namespace Workflow\Execution\Handler;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Application\Common\KeyGeneratorInterface;
use Workflow\Execution\Handler\Exception\InvalidHandlerParameterException;
use Workflow\Entity\Instance;
use Workflow\Entity\Transition;
use Workflow\Entity\Workitem;
use Doctrine\ORM\UnitOfWork;

/**
 * Handler untuk transisi dengan trigger jenis 'USER'.
 * Inti dari handler ini adalah membuat workitem baru untuk transition bersangkutan.
 * 
 * @author zakyalvan
 */
class UserTriggeredTransitionHandler implements TransitionHandler, ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Handler\TransitionHandler::canHandle()
	 */
	public function canHandle(Transition $transition, Instance $instance) {
		return true;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Handler\TransitionHandler::handle()
	 */
	public function handle(Transition $transition, Instance $instance) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		// Ensure managed entity
		$transitionState = $entityManager->getUnitOfWork()->getEntityState($transition);
		if($transitionState != UnitOfWork::STATE_DETACHED || $transitionState != UnitOfWork::STATE_MANAGED) {
			throw new \InvalidArgumentException('Parameter transition harus merupakan object entity dalam state managed atau detached', 100, null);
		}
		if($transitionState == UnitOfWork::STATE_DETACHED) {
			$transition = $entityManager->merge($transition);
		}
		
		$instanceState = $entityManager->getUnitOfWork()->getEntityState($instance);
		if($instanceState != UnitOfWork::STATE_DETACHED || $instanceState != UnitOfWork::STATE_MANAGED) {
			throw new \InvalidArgumentException('Parameter instance harus merupakan object entity dalam state managed atau detached', 101, null);
		}
		if($instanceState == UnitOfWork::STATE_DETACHED) {
			$instance = $entityManager->merge($instance);
		}
		
		/* @var $keyGenerator KeyGeneratorInterface */ 
		$keyGenerator = $this->serviceLocator->get('Application\Common\KeyGeneratator');
		
		$entityManager->beginTransaction();
		try {
			$workitem = new Workitem();
			$workitem->setId($keyGenerator->generateNextKey($workitem, 'id'));
			$workitem->setInstance($instance);
			$workitem->setTransition($transition);
			$workitem->setStatus(Workitem::STATUS_ENABLED);
			$workitem->setEnabledDate(new \DateTime(null, null));
			
			$workitem = $entityManager->merge($workitem);
			$entityManager->flush($workitem);
			$entityManager->commit();
		}
		catch(\Exception $e) {
			$entityManager->rollback();
			throw new \RuntimeException(sprintf('Simpan workitem baru gagal, sebuah eksepsi terjadi pada saat proses penyimpanan workitem. Perhatikan stack trace.'), 100, $e);
		}
	}
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}