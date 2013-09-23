<?php
namespace Workflow\Router;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Workflow\Router\Exception\RouterException;
use Workflow\Entity\Token;

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
	 * Route sebuah token dari satu place ke place berikutnya.
	 * 
	 * @param Token $token
	 * @return Result
	 */
	public function routeToNextPlace(Token $token) {
		if($token == null) {
			throw new RouterException("Invalid parameter, token tidak boleh null.", 100, null);
		}
		
		$place = $token->getPlace();
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