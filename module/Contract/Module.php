<?php
namespace Contract;

use Zend\ModuleManager\Feature\ConfigProviderInterface as ConfigProvider;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface as AutoloaderProvider;
use Zend\ModuleManager\Feature\InitProviderInterface as InitProvider;
use Zend\ModuleManager\ModuleManagerInterface as ModuleManager;

/**
 * Contract Module
 * 
 * @author zakyalvan
 */
class Module implements InitProvider, AutoloaderProvider, ConfigProvider {
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\InitProviderInterface::init()
	 */
	public function init(ModuleManager $manager) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\AutoloaderProviderInterface::getAutoloaderConfig()
	 */
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
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\ConfigProviderInterface::getConfig()
	 */
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
}