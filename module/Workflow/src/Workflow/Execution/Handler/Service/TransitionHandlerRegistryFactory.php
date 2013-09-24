<?php
namespace Workflow\Execution\Handler\Service;

use Zend\ServiceManager\FactoryInterface as Factory;
use Workflow\Execution\Handler\TransitionHandlerRegistry;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

/**
 * Factory untuk kelas TransitionHandlerRegistry
 * 
 * @author zakyalvan
 */
class TransitionHandlerRegistryFactory implements Factory {
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		$config = $serviceLocator->get('Config');
		
		$transitionHandlerRegistry = new TransitionHandlerRegistry();
		if(isset($config['workflow']['transition_handlers'])) {
			try {
				foreach ($config['workflow']['transition_handlers'] as $name => $handler) {
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