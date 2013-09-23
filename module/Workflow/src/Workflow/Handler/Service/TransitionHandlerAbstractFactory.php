<?php
namespace Workflow\Handler\Service;

use Zend\ServiceManager\AbstractFactoryInterface as AbstractFactory;

/**
 * Abstract factory untuk transition handler.
 * 
 * @author zakyalvan
 */
class TransitionHandlerAbstractFactory implements AbstractFactory {
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractFactoryInterface::canCreateServiceWithName()
	 */
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractFactoryInterface::createServiceWithName()
	 */
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		
	}
}