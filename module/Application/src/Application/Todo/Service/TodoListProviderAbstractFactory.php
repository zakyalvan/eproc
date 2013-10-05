<?php
namespace Application\Todo\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Application\Todo\TodoListProviderRegistry;

/**
 * Create todo list berdasarkan jenisnya.
 * 
 * @author zakyalvan
 */
class TodoListProviderAbstractFactory implements AbstractFactoryInterface {
	const DEFAULT_TODO_CONFIG_KEY = 'todo_list';
	
	/**
	 * @var TodoListProviderConfig
	 */
	private $providerConfig = null;
	
	/**
	 * 
	 * @var TodoListProviderRegistry
	 */
	private $providerRegistry = null;
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractFactoryInterface::canCreateServiceWithName()
	 */
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		// Jika belum pernah dipanggil sebelumnya, inisiasi dulu provider config.
		if($this->providerRegistry == null) {
			$config = $serviceLocator->get('Config');
				
			if(!isset($config[self::DEFAULT_TODO_CONFIG_KEY])) {
				return false;
			}
				
			$this->providerRegistry = new TodoListProviderRegistry();
			if(isset($config[self::DEFAULT_TODO_CONFIG_KEY]['providers'])) {
				$this->providerRegistry->addAll($config[self::DEFAULT_TODO_CONFIG_KEY]['providers']);
			}
		}
		// Sekarang baru evaluasi apakah service yang diminta bisa dibuat atau tidak.
		return $this->providerRegistry->has($requestedName);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractFactoryInterface::createServiceWithName()
	 */
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		if(!$this->providerRegistry->has($requestedName)) {
			throw new ServiceNotCreatedException(sprintf('Service todo list provider dengan nama %s tidak ditemukan dalam registry', $requestedName), 100, null);
		}
		
		$class = $this->providerRegistry->get($requestedName);
		return new $class();
	}
}