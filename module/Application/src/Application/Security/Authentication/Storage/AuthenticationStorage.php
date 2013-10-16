<?php
namespace Application\Security\Authentication\Storage;

use Zend\Authentication\Storage\StorageInterface as Storage;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Application\Security\SecurityContext;
use Zend\Session\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Custom session storage.
 * 
 * @author zakyalvan
 */
class AuthenticationStorage implements Storage {
	const SESSION_NAMESPACE = 'security_context';
	
	const STORAGE_KEY = 'login_info';
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * @var Container
	 */
	private $sessionContainer;
	
	private $storageKey;
	
	public function __construct(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
		$this->sessionContainer = new Container(self::SESSION_NAMESPACE);
		$this->storageKey = self::STORAGE_KEY;
	}
	
	public function isEmpty() {
		return !isset($this->sessionContainer->{$this->storageKey});
	}
	
	public function read() {
		if(!isset($this->sessionContainer->{$this->storageKey})) {
			return null;
		}
		
		$securityContextArray = $this->sessionContainer->{$this->storageKey};
		
		/* @var $entityManager EntityManager */ 
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$queryBuilder = $entityManager->createQueryBuilder();
		
		/* @var $securityContext SecurityContext */
		$user = $queryBuilder->select('user')
			->from('Application\Entity\User', 'user')
			->where($queryBuilder->expr()->eq('user.kode', ':kodeLoggedinUser'))
			->setParameter('kodeLoggedinUser', $securityContextArray['loggedinUser'])
			->getQuery()
			->getSingleResult();
		
		//$securityContext->getLoggedinTime()->
		
		return new SecurityContext($user);
	}
	
	public function write($contents) {
		if(!$contents instanceof SecurityContext) {
			throw new \InvalidArgumentException(sprintf('Parameter dalam penulisan ke auth storage harus berupa object security context'), 100, null);
		}
		
		$securityContextArray['loggedinUser']  = $contents->getLoggedinUser()->getKode();
		$securityContextArray['activeRole'] = $contents->hasActiveRole() ? $contents->getActiveRole()->getKode() : null;
		$securityContextArray['loggedinTime'] = $contents->getLoggedinTime()->format('d M Y');
		
		$this->sessionContainer->{$this->storageKey} = $securityContextArray;
	}
	
	public function clear() {
		unset($this->sessionContainer->{$this->storageKey});
	}
}