<?php
namespace Contract\Service\Factory;

use Zend\ServiceManager\AbstractFactoryInterface as AbstractFactory;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

/**
 * Abstract factory untuk contract-list-provider.
 * 
 * @author zakyalvan
 */
class ContractListProviderAbstractFactory implements AbstractFactory {
	/**
	 * @var ContractListProviderRegistry
	 */
	private $registry;
	
	public function canCreateServiceWithName(ServiceLocator $serviceLocator, $name, $requestedName) {
		if($this->registry == null) {
			$config = $serviceLocator->get('Config');
			
			if(!isset($config['contract']['list_providers'])) {
				return false;
			}
			
			$this->registry = new ContractListProviderRegistry();
			$this->registry->addAll($config['contract']['list_providers']);
		}
		
		return $this->registry->has($requestedName);
	}
	
	public function createServiceWithName(ServiceLocator $serviceLocator, $name, $requestedName) {
		if(!$this->canCreateServiceWithName($serviceLocator, $name, $requestedName)) {
			throw new ServiceNotCreatedException(sprintf('Object contract-list-provider dengan nama %s tidak dapat dibuat, tidak ditemukan dalam registry', $requestedName), 100, null);
		}
		
		$requestedClass = $this->registry->get($requestedName);
		if($requestedClass instanceof \Closure) {
			throw new ServiceNotCreatedException(sprintf('Belum dapat menghandle Closure'), 100, null);
		}
		else {
			return new $requestedClass();
		}
	}
}