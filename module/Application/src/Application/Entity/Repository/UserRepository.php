<?php
namespace Application\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Role;
use Application\Entity\Kantor;
use Application\Entity\User;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Custom repository untuk entity {@link User}
 * 
 * @author zakyalvan
 */
class UserRepository extends EntityRepository {
	/**
	 * Retrieve daftar user berdasarkan kantor dan role.
	 * 
	 * @param Kantor $kantor
	 * @param Role $role
	 */
	public function findUsersByKantorAndRole($kantor, $role) {
		$kodeKantor = null;
		if($kantor instanceof Kantor) {
			$kodeKantor = $kantor->getKode();
		}
		else if(is_string($kantor) || is_array($kantor)) {
			$kodeKantor = $kantor;
		}
		else {
			throw new \InvalidArgumentException('Parameter kantor harus object instance dari Application\Entity\Kantor atau string kode kantor', 100, null);
		}
		
		$kodeRole = null;
		if($role instanceof Role) {
			$kodeRole = $role->getKode();
		}
		else if(is_string($role)) {
			$kodeRole = $role;
		}
		else {
			throw new \InvalidArgumentException('Parameter role harus object instance dari Application\Entity\Role atau string kode role', 100, null);
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		return $queryBuilder->select('user')
			->from('Application\Entity\User', 'user')
			->innerJoin('user.listUserRole', 'listUserRole')
			->innerJoin('listUserRole.role', 'role', Join::WITH, $queryBuilder->expr()->eq('role.kode', ':kodeRole'))
			->innerJoin('listUserRole.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', 'kodeKantor'))
			->setParameter('kodeRole', $kodeRole)
			->setParameter('kodeKantor', $kodeKantor)
			->getQuery()
			->getResult();
	}
}