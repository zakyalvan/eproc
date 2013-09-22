<?php
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Loader\AutoloaderFactory;
use Zend\Session\Container;

/**
 * Definisi dan konfigurasi untuk modul Application
 * 
 * @author zakyalvan
 */
class Module implements ConfigProviderInterface, AutoloaderProviderInterface, ServiceProviderInterface {
	public function onBootstrap(MvcEvent $e) {
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
		
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
    
    /**
     * (non-PHPdoc)
     * @see \Zend\ModuleManager\Feature\ServiceProviderInterface::getServiceConfig()
     */
    public function getServiceConfig() {
    	return array(
    		'factories' => array(
    			/**
    			 * Seharusnya di simpan di application-wide config (di config/autoload/global.php bukan di sini,
    			 * tapi ga apalah, toh dimerge juga).
    			 * 
    			 * @see https://github.com/doctrine/DoctrineModule/blob/master/docs/authentication.md
    			 */
    			'Zend\Authentication\AuthenticationService' => function($serviceManager) {
    				return $serviceManager->get('doctrine.authenticationservice.orm_default');
    			}
    		)
    	);
    }
}
