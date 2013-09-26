<?php
namespace Procurement;

use Zend\ModuleManager\Feature\InitProviderInterface as InitProvider;
use Zend\ModuleManager\Feature\ConfigProviderInterface as ConfigProvider;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface as AutoloaderProvider;

/**
 * Konfigurasi untuk module Procurement
 * 
 * @author zakyalvan
 */
class Module implements InitProvider, ConfigProvider, AutoloaderProvider {
	public function init(ModuleManagerInterface $manager) {
		
	}
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
}