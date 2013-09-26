<?php
namespace Workflow\Execution\Handler\Service;

use Zend\ServiceManager\FactoryInterface as Factory;
use Workflow\Execution\Handler\TransitionHandlerRegistry;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

/**
 * Factory untuk kelas TransitionHandlerRegistry
 * 
 * @author zakyalvan
 */
class TransitionHandlerRegistryFactory implements Factory {
	const DEFAULT_REGISTRY_CONFIG_KEY = 'transition_handlers';
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(ServiceLocator $serviceLocator) {
		$config = $serviceLocator->get('Config');
		
		$transitionHandlerRegistry = new TransitionHandlerRegistry();
		if(isset($config['workflow'][self::DEFAULT_REGISTRY_CONFIG_KEY])) {
			try {
				foreach ($config['workflow'][self::DEFAULT_REGISTRY_CONFIG_KEY] as $name => $handler) {
					$transitionHandlerRegistry->add($name, $handler);
				}
			}
			catch(\Exception $e) {
				throw new ServiceNotCreatedException("Object transition handler registry tidak dapat dibuat, terjadi eksepsi", 100, $e);
			}
		}
		return $transitionHandlerRegistry;
	}
}