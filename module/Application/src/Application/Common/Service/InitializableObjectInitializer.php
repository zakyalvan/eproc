<?php
namespace Application\Common\Service;

use Zend\ServiceManager\InitializerInterface as Initializer;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Stdlib\InitializableInterface as Initializable;

/**
 * Initializer untuk object yang mengimplement {@link InitializableInterface}.
 * Sebenarnya cuma manggil(in) method init dari object tersebut.
 * 
 * @author zakyalvan
 */
class InitializableObjectInitializer implements Initializer {
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\InitializerInterface::initialize()
	 */
	public function initialize($instance, ServiceLocator $serviceLocator) {
		if($instance instanceof Initializable) {
			$instance->init();
		}
		return $instance;
	}
}