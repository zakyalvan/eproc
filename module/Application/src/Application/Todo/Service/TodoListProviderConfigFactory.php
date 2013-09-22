<?php
namespace Application\Todo\Service;

use Zend\ServiceManager\FactoryInterface;
use Application\Todo\TodoListProviderConfig;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory untuk kelas TodoListProviderConfig
 * 
 * @author zakyalvan
 */
class TodoListProviderConfigFactory implements FactoryInterface {
	const DEFAULT_TODO_CONFIG_KEY = 'todo_list';
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		$config = $serviceLocator->get('Config');
		
		if(!isset($config[self::DEFAULT_TODO_CONFIG_KEY])) {
			throw new ServiceNotCreatedException('Item konfigurasi ' . TodoListProviderConfig::DEFAULT_TODO_CONFIG_KEY . ' tidak ditemukan dalam konfigurasi', 101, null);
		}
		
		$providerConfig = new TodoListProviderConfig();
		if(isset($config[self::DEFAULT_TODO_CONFIG_KEY]['providers'])) {
			$providerConfig->setProviders($config[self::DEFAULT_TODO_CONFIG_KEY]['providers']);
		}
		
		return $providerConfig;
	}
}