<?php
namespace Application\Common\Service;

use Zend\ServiceManager\InitializerInterface as Initializer;
use Application\Common\IdentityAwareInterface as IdentityAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Authentication\AuthenticationService;
use Application\Common\Service\Exception\AuthenticationServiceNotFoundException;

/**
 * Inject identity dalam object yang membutuhkanannya.
 * 
 * @author zakyalvan
 */
class IdentityAwareInitializer implements Initializer {
	/**
	 * @var AuthenticationService
	 */
	private $authenticationService;
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\InitializerInterface::initialize()
	 */
	public function initialize($instance, ServiceLocator $serviceLocator) {
		if($instance instanceof IdentityAware) {
			if(!$serviceLocator->has('Zend\Authentication\AuthenticationService')) {
				throw new AuthenticationServiceNotFoundException("Object dengan nama 'Zend\Authentication\AuthenticationService' (instance dari kelas dengan nama sama) tidak ditemukan dalam service locator. Identity aware initilizer harus digunakan bersama dengan obejct kelas tersebut (terdaftar dalam service locator)", 0, null);
			}
			
			if($this->authenticationService == null) {
				$this->authenticationService = $serviceLocator->get('Zend\Authentication\AuthenticationService');
			}

			if($this->authenticationService->hasIdentity()) {
				$instance->injectIdentity($this->authenticationService->getIdentity());
			}
		}
		return $instance;
	}
}