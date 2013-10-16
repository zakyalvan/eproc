<?php
namespace Application\Security\Factory;

use Zend\ServiceManager\FactoryInterface as Factory;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Authentication\AuthenticationService;
use Application\Security\Authentication\Adapter\AuthenticationAdapter;
use Application\Security\Authentication\Storage\AuthenticationStorage;

/**
 * Factory untuk auth-service.
 * 
 * @author zakyalvan
 */
class AuthenticationServiceFactory implements Factory {
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(ServiceLocator $serviceLocator) {
		$authService = new AuthenticationService();
		
		$authAdapter = new AuthenticationAdapter($serviceLocator);
		$authAdapter->setUseDevelopmentMode(true);
		$authService->setAdapter($authAdapter);
		
		$authService->setStorage(new AuthenticationStorage($serviceLocator));
		return $authService;
	}
}