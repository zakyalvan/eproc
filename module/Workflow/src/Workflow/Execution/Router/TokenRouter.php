<?php
namespace Workflow\Execution\Router;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Workflow\Execution\Router\Exception\RouterException;
use Workflow\Entity\Token;
use Doctrine\ORM\EntityManager;

/**
 * Router untuk token.
 * Object dari kelas ini seharusnya dibikin instance-nya dalam ServiceManager.
 * 
 * @author zakyalvan
 */
class TokenRouter implements ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * @var EntityManager
	 */
	private $entityManager;
	
	/**
	 * Route sebuah token dari satu place ke place berikutnya.
	 * 
	 * @param Token $token
	 * @return RouteResult
	 */
	public function routeToNextPlace(Token $token) {
		if($token == null || $token->getId() == null) {
			throw new RouterException("Invalid parameter, token tidak boleh null atau token yang diberikan harus dipersist (id != null).", 100, null);
		}
		
		if($this->entityManager == null) {
			$this->entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		}
		
		// Hindari token yang diupdate diluar, ambil token langsung dari repositorynya.
		$tokeRepository = $this->entityManager->getRepository('Workflow\Entity\Token');
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
	 */
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}