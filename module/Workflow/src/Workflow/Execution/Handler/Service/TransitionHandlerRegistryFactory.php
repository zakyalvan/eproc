<?php
namespace Workflow\Execution\Handler\Service;

use Zend\ServiceManager\FactoryInterface as Factory;
use Workflow\Execution\Handler\TransitionHandlerRegistry;

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
		
		$transitionHandlerRegister = new TransitionHandlerRegistry();
		if(isset($config['workflow']['transition_handlers'])) {
			foreach ($config['workflow']['transition_handlers'] as $name => $handler) {
				$transitionHandlerRegister->add($name, $handler);
			}
		}
		return $transitionHandlerRegister;
	}
}