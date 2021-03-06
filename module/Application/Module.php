<?php
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ConfigProviderInterface as ConfigProvider;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface as AutoloaderProvider;
use Zend\Loader\AutoloaderFactory;
use Zend\Session\Container;
use Application\Security\SecurityInterceptListener;

/**
 * Definisi dan konfigurasi untuk modul Application
 * 
 * @author zakyalvan
 */
class Module implements ConfigProvider, AutoloaderProvider {
	public function onBootstrap(MvcEvent $e) {
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
		
		$securityInterceptListener = new SecurityInterceptListener();
		$securityInterceptListener->attach($eventManager);
		
		// Start session.
		if($e->getApplication()->getServiceManager()->has('Zend\Session\SessionManager')) {
			$sessionManager = $e->getApplication()->getServiceManager()->get('Zend\Session\SessionManager');
			$sessionManager->start();
			
			$container = new Container('initialized');
			if(!isset($container->init)) {
				$sessionManager->regenerateId();
				$container->init = 1;
			}
		}
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return array(
			AutoloaderFactory::STANDARD_AUTOLOADER => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				)
			)
		);
	}
}
