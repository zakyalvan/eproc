<?php
namespace Application\Persistence\Service;

use Zend\ServiceManager\InitializerInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\Exception\RuntimeException;

/**
 * Initialize object-object yang bergantung pada object-manager (Doctrine Orm).
 * Jadi semua object yang di daftarkan dalam service manager dan mengimplementasi
 * interface {@link DoctrineModule\Persistence\ObjectManagerAwareInterface} akan
 * secara otomatis diinject object manager nya.
 * 
 * @author zakyalvan
 */
class ObjectManagerAwareInitializer implements InitializerInterface {
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\InitializerInterface::initialize()
	 */
	public function initialize($instance, ServiceLocatorInterface $serviceLocator) {
		// Kalau interface dari doctrine modul di-implement.
		if($instance instanceof ObjectManagerAwareInterface) {
			if($serviceLocator->has('Doctrine\ORM\EntityManager')) {
				$objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
				$instance->setObjectManager($objectManager);
			}
		}
		return $instance;
	}
}