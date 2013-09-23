<?php
namespace Workflow\Execution\Handler\Service;

use Zend\ServiceManager\AbstractFactoryInterface as AbstractFactory;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

/**
 * Abstract factory untuk transition handler.
 * 
 * @author zakyalvan
 */
class TransitionHandlerAbstractFactory implements AbstractFactory {
	/**
	 * @var TransitionHandlerRegistry
	 */
	private $transitionHandlerRegistry = array();
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractFactoryInterface::canCreateServiceWithName()
	 */
	public function canCreateServiceWithName(ServiceLocator $serviceLocator, $name, $requestedName) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractFactoryInterface::createServiceWithName()
	 */
	public function createServiceWithName(ServiceLocator $serviceLocator, $name, $requestedName) {
		
	}
}