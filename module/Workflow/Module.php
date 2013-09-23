<?php
namespace Workflow;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Workflow\Service\DefaultDefinitionService;

/**
 * Definisi dan konfigurasi module workflow.
 * 
 * @author zakyalvan
 */
class Module implements InitProviderInterface, AutoloaderProviderInterface, ConfigProviderInterface {
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
}