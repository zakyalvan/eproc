<?php
namespace Workflow\Execution\Handler;

use Workflow\Execution\Handler\Exception\InvalidHandlerParameterException;
use Workflow\Entity\Instance;
use Workflow\Entity\Transition;
use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Workflow\Entity\Workitem;
use Doctrine\ORM\EntityManager;

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
	 * @var EntityManager
	 */
	private $entityManager;
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Handler\TransitionHandler::canHandle()
	 */
	public function canHandle(Transition $transition, Instance $instance) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Handler\TransitionHandler::handle()
	 */
	public function handle(Transition $transition, Instance $instance) {
		if(!($transition != null && $transition->getId() != null)) {
			throw new \InvalidArgumentException('Nilai parameter transition tidak boleh null atau non managed entity', 100, null);
		}
		if(!($instance != null && $instance->getId() != null)) {
			throw new \InvalidArgumentException('Parameter instance tidak boleh null atau non managed entity', 100, null);
		}
		
		if($transition->getWorkflow()->getId() != $instance->getWorkflow()->getId()) {
			throw new \InvalidArgumentException('', 102, null);
		}
		
		// Create new workitem.
		$workitem = new Workitem();
		$workitem->setId();
		$workitem->setInstance($instance);
		$workitem->setTransition($transition);
		$workitem->setStatus(Workitem::STATUS_ENABLED);
		/**
		 * TODO Set enabled date untuk workitem.
		 */
		
		$this->entityManager->persist($workitem);
	}
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
		
		if($this->entityManager == null) {
			$this->entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		}
	}
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}