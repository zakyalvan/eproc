<?php
namespace Workflow\Execution\Handler\Service;

use Zend\ServiceManager\AbstractFactoryInterface as AbstractFactory;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Workflow\Execution\Handler\TransitionHandlerRegistry;
use Workflow\Execution\Handler\TransitionHandlerRegistryHolder;

/**
 * Abstract factory untuk transition handler.
 * 
 * @author zakyalvan
 */
class TransitionHandlerAbstractFactory implements AbstractFactory, TransitionHandlerRegistryHolder {
	/**
	 * @var TransitionHandlerRegistry
	 */
	private $transitionHandlerRegistry;
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractFactoryInterface::canCreateServiceWithName()
	 */
	public function canCreateServiceWithName(ServiceLocator $serviceLocator, $name, $requestedName) {
		if($this->transitionHandlerRegistry == null) {
			if($serviceLocator->has('Workflow\Execution\Handler\Service\TransitionHandlerRegistry')) {
				$this->transitionHandlerRegistry = $serviceLocator->get('Workflow\Execution\Handler\Service\TransitionHandlerRegistry');
			}
			else {
				$config = $serviceLocator->get('Config');
				$this->transitionHandlerRegistry = new TransitionHandlerRegistry();
				
				if(isset($config['workflow']['transition_handlers'])) {
					foreach ($config['workflow']['transition_handlers'] as $alias => $handler) {
						$this->transitionHandlerRegistry->add($alias, $handler);
					}
				}
			}
		}
		
		// Tidak perlu terlalu banyak cek, karena dari awal sudah dipaksa valid pada saat masukin ke registry.
		return $this->transitionHandlerRegistry->has($requestedName);
	}
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractFactoryInterface::createServiceWithName()
	 */
	public function createServiceWithName(ServiceLocator $serviceLocator, $name, $requestedName) {
		if(!$this->canCreateServiceWithName($serviceLocator, $name, $requestedName)) {
			throw new ServiceNotCreatedException("Service dengan nama {$requestedName} tidak dapat dicrete", 0, null);
		}
		
		$class = $this->transitionHandlerRegistry->get($requestedName);
		return new $class();
	}
	
	/**
	 * @return \Workflow\Execution\Handler\TransitionHandlerRegistry
	 */
	public function getRegistry() {
		return $this->transitionHandlerRegistry;
	}
}