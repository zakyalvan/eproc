<?php
namespace Contract;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 * Contract Module
 * 
 * @author zakyalvan
 */
class Module implements InitProviderInterface, AutoloaderProviderInterface, ConfigProviderInterface, ServiceProviderInterface {
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\InitProviderInterface::init()
	 */
	public function init(ModuleManagerInterface $manager) {
		
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
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\ServiceProviderInterface::getServiceConfig()
	 */
	public function getServiceConfig() {
		return array(
			'factories' => array(
				
			)
		);
	}
}