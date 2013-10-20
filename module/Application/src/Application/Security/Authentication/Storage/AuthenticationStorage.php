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
	const SESSION_NAMESPACE = 'security_context_container';
	
	const STORAGE_KEY = 'login_info_custom';
	
	/**
	 * Cached sercurity context.
	 * 
	 * @var SecurityContext
	 */
	private $cachedSecurityContext;
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * @var Container
	 */
	private $sessionContainer;
	
	/**
	 * Nama key (dalam container namespace untuk menyimpan informasi login)
	 * 
	 * @var string
	 */
	private $storageKey;
	
	private $dateTimeFormat = 'd/m/Y H:i:s';
	
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
		
		if($this->cachedSecurityContext != null) {
			return $this->cachedSecurityContext;
		}
		
		$securityContextArray = $this->sessionContainer->{$this->storageKey};
		
		/* @var $entityManager EntityManager */ 
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		$userQueryBuilder = $entityManager->createQueryBuilder();
		
		/* @var $user User */
		$user = $userQueryBuilder->select(array('user', 'kantor'))
			->from('Application\Entity\User', 'user')
			->innerJoin('user.kantor', 'kantor')
			->where($userQueryBuilder->expr()->eq('user.kode', ':kodeUser'))
			->setParameter('kodeUser', $securityContextArray['loggedinUser'])
			->getQuery()
			->getSingleResult();
		
		$rolesQueryBuilder = $entityManager->createQueryBuilder();
		$availableRoles = $rolesQueryBuilder->select('role')
			->from('Application\Entity\Role', 'role')
			->innerJoin('role.listUserRole', 'listUserRole')
			->innerJoin('listUserRole.kantor', 'kantor', Join::WITH, $rolesQueryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->where($rolesQueryBuilder->expr()->in('role.kode', ':availableRoles'))
			->setParameter('kodeKantor', $user->getKantor()->getKode())
			->setParameter('availableRoles', $securityContextArray['availableRoles'])
			->getQuery()
			->getResult();
		
		$loggedinTime = \DateTime::createFromFormat($this->dateTimeFormat, $securityContextArray['loggedinTime']);
		
		if($securityContextArray['activeRole'] != null) {
			$roleQueryBuilder = $entityManager->createQueryBuilder();
			$activeRole = $roleQueryBuilder->select('role')
				->from('Application\Entity\Role', 'role')
				->where($roleQueryBuilder->expr()->eq('role.kode', ':kodeRole'))
				->setParameter('kodeRole', $securityContextArray['activeRole'])
				->getQuery()
				->getSingleResult();
			$securityContext = new SecurityContext($user, $availableRoles, $activeRole, $loggedinTime);
			$this->cachedSecurityContext = $securityContext;
			
			return $securityContext;
		}
		
		$securityContext = new SecurityContext($user, $availableRoles, null, $loggedinTime);
		$this->cachedSecurityContext = $securityContext;
		
		return $securityContext;
	}
	
	public function write($contents) {
		if(!$contents instanceof SecurityContext) {
			throw new \InvalidArgumentException(sprintf('Parameter dalam penulisan ke auth storage harus berupa object security context'), 100, null);
		}
		
		// Kosongkan cached security context.
		$this->cachedSecurityContext = null;
		
		$availableRoles = array();
		
		foreach ($contents->getAvailableRoles() as $role) {
			$availableRoles[] = $role->getKode();
		}
		
		$securityContextArray['loggedinUser']  = $contents->getLoggedinUser()->getKode();
		$securityContextArray['availableRoles'] = $availableRoles;
		$securityContextArray['activeRole'] = $contents->hasActiveRole() ? $contents->getActiveRole()->getKode() : null;
		$securityContextArray['loggedinTime'] = $contents->getLoggedinTime()->format($this->dateTimeFormat);
		
		$this->sessionContainer->{$this->storageKey} = $securityContextArray;
	}
	
	public function clear() {
		unset($this->sessionContainer->{$this->storageKey});
		$this->cachedSecurityContext = null;
	}
}