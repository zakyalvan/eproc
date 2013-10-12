<?php
namespace Application\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Application\Entity\Repository\UserRepository;

class ApplicationService implements ApplicationServiceInterface, ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function getOneUserByKode($kode) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		/* @var $userRepository UserRepository */
		$userRepository = $entityManager->getRepository('Application\Entity\User');
		
		return $userRepository->find($kode);
	}
	
	public function getListUserByRole($role, $kantor) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		/* @var $userRepository UserRepository */
		$userRepository = $entityManager->getRepository('Application\Entity\User');
		
		return $userRepository->findAllByKantorAndRole($kantor, $role);
	}
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}