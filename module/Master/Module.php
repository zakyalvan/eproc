<?php
namespace Master;

use Zend\ModuleManager\Feature\ConfigProviderInterface as ConfigProvider;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface as AutoloaderProvider;
use Zend\ModuleManager\Feature\InitProviderInterface as InitProvider;
use Zend\ModuleManager\ModuleManagerInterface as ModuleManager;

class Module implements ConfigProvider, AutoloaderProvider, InitProvider {
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php'
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
				)
			)
		);
	}
	
	public function init(ModuleManager $manager) {
		
	}
}