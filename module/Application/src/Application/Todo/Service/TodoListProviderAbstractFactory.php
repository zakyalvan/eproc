<?php
namespace Application\Todo\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Application\Todo\TodoListProviderConfig;

/**
 * Create todo list berdasarkan jenisnya.
 * 
 * @author zakyalvan
 */
class TodoListProviderAbstractFactory implements AbstractFactoryInterface {
	/**
	 * @var TodoListProviderConfig
	 */
	private $providerConfig = null;
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractFactoryInterface::canCreateServiceWithName()
	 */
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
 		if(!class_exists($requestedName, true)) {
 			return false;
 		}
 		
		$interfaces = class_implements($requestedName, true);
		if(!array_key_exists('Application\Todo\TodoListProvider', $interfaces)) {
			return false;
		}
		
		// Jika belum pernah dipanggil sebelumnya, inisiasi dulu provider config.
		if($this->providerConfig == null) {
			//if($serviceLocator->has('Application\Todo\TodoListProviderConfig')) {				
			//	$this->providerConfig = $serviceLocator->get('Application\Todo\TodoListProviderConfig');
			//}
			//else  {
				$config = $serviceLocator->get('Config');
				
				if(!isset($config[TodoListProviderConfigFactory::DEFAULT_TODO_CONFIG_KEY])) {
					throw new ServiceNotCreatedException('Konfigurasi todo list dengan key ' . TodoListProviderConfig::DEFAULT_TODO_CONFIG_KEY . ' tidak ditemukan', 100, null);
				}
				
				$this->providerConfig = new TodoListProviderConfig();
				if(isset($config[TodoListProviderConfigFactory::DEFAULT_TODO_CONFIG_KEY]['providers'])) {
					$this->providerConfig->setProviders($config[TodoListProviderConfigFactory::DEFAULT_TODO_CONFIG_KEY]['providers']);
				}
			//}
		}
		// Sekarang baru evaluasi apakah service yang diminta bisa dibuat atau tidak.
		return $this->providerConfig->hasProvider($requestedName);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractFactoryInterface::createServiceWithName()
	 */
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		$class = $this->providerConfig->getProvider($requestedName);
		
		if(!class_exists($class)) {
			throw new ServiceNotCreatedException("Kelas to do provider yang diminta {$class} tidak ditemukan.");
		}
		
		$todoListProvider = new $class();
		return $todoListProvider;
	}
}