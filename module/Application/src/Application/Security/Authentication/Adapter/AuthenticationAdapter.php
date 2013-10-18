<?php
namespace Application\Security\Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Zend\Authentication\Result;
use Application\Entity\User;
use Application\Security\SecurityContext;

/**
 * Custom auth adapter.
 * 
 * @author zakyalvan
 */
class AuthenticationAdapter implements AdapterInterface {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * Username
	 * 
	 * @var string
	 */
	private $identityValue;
	
	/**
	 * Password
	 * 
	 * @var string
	 */
	private $creadentialValue;
	
	private $useDevelopmentMode = false;
	
	public function __construct(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	
	public function setIdentityValue($identityValue) {
		$this->identityValue = $identityValue;
	}
	public function setCredentialValue($credentialValue) {
		$this->creadentialValue = $credentialValue;
	}
	public function setUseDevelopmentMode($useDevelopmentMode) {
		$this->useDevelopmentMode = $useDevelopmentMode;
	}
	
	public function authenticate() {
		if($this->identityValue == null) {
			return new Result(Result::FAILURE, null, array('Username belum diberikan.'));
		}
		
		/* @var $entityManager EntityManager */ 
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		$queryBuilder = $entityManager->createQueryBuilder();
		
		/* @var $securityContext SecurityContext */ 
		$user = $queryBuilder->select(array('user', 'kantorUser', 'listUserRole', 'role'))
			->from('Application\Entity\User', 'user')
			->innerJoin('user.kantor', 'kantorUser')
			->innerJoin('user.listUserRole', 'listUserRole')
			->innerJoin('listUserRole.kantor', 'kantorUserRole', Join::WITH, $queryBuilder->expr()->eq('kantorUser.kode', 'kantorUserRole.kode'))
			->innerJoin('listUserRole.role', 'role')
			->where($queryBuilder->expr()->eq('user.kode', ':userIdentity'))
			->setParameter('userIdentity', $this->identityValue)
			->getQuery()
			->getOneOrNullResult();
		
		if($user == null) {
			return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, array('User dengan username yang diberikan tidak ditemukan dalam database'));
		}
		
		if(!$this->useDevelopmentMode && $user->getPassword() !== $this->creadentialValue) {
			return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array('Password yang diberikan tidak valid'));
		}
		return new Result(Result::SUCCESS, new SecurityContext($user));
	}
}