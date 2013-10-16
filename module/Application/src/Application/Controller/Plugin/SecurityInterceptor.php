<?php
namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\AuthenticationService;
use Application\Security\SecurityContext;

/**
 * Abstract plugin untuk intercept masalah security.
 * Disini user akan dicheck apakah sudah login atau belum sebelum mengakses halaman yang seharusnya diakses oleh
 * user yang sudah login, apakah user diizinkan untuk mengakses berdasarkan rolenya.
 * 
 * @author zakyalvan
 */
class SecurityInterceptor extends AbstractPlugin {
	public function intercept() {
		$controller = $this->getController();
		if(!$controller instanceof AbstractActionController) {
			throw new \RuntimeException(sprintf('Plugin %s tidak dapat digunakan dalam controller yang bukan instance dari %s', get_class($this), 'Zend\Mvc\Controller\AbstractActionController'), 100, null);
		}
		
		/* @var $serviceLocator ServiceLocatorInterface */ 
		$serviceLocator = $controller->getServiceLocator();
		if(!$serviceLocator->has('Zend\Authentication\AuthenticationService')) {
			throw new \RuntimeException(sprintf('Object auth service dengan key %s tidak terdaftar dalam service registry.', 'Zend\Authentication\AuthenticationService'), 100, null);
		}
		
		/* @var $authenticationService AuthenticationService */ 
		$authenticationService = $serviceLocator->get('Zend\Authentication\AuthenticationService');
		if($authenticationService->hasIdentity()) {
			/* @var $securityContext SecurityContext */
			$securityContext = $authenticationService->getIdentity();
			if(!$securityContext->hasActiveRole()) {
				$controller->redirect()->toRoute('contract');
			}
		}
		else {
			
		}
	}
}