<?php
namespace Application\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Role;
use Application\Entity\Kantor;
use Application\Entity\User;

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
	public function findAllUserByKantorAndRole(Kantor $kantor, Role $role) {
		return $this->_em->createQuery('SELECT user FROM Application\Entity\User user INNER JOIN user.kantor WITH user.kantor.kode = :kodeKantor INNER JOIN user.roles WITH user.roles.kode = :kodeRole')
			->setParameter('kodeKantor', $kantor->getKode())
			->setParameter('kodeRole', $role->getKode())
			->getResult();
	}
}