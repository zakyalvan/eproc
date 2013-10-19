<?php
namespace Application\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\UnitOfWork;

/**
 * Ini custom entity repository. Cuman nambah helper method saja.
 * 
 * @author zakyalvan
 */
class CustomEntityRepository extends EntityRepository {
	/**
	 * Helper method untuk memastikan sebuah entity dalam state managed (Jika detached maka dimerge).
	 * 
	 * @param entity $entity
	 * @throws \InvalidArgumentException
	 * @return entity
	 */
	protected function ensureManagedEntity($entity) {
		if($entity == null) {
			throw new \InvalidArgumentException('Parameter entity tidak boleh null', 100, null);
		}
	
		$entityState = $this->getEntityManager()->getUnitOfWork()->getEntityState($entity);
		if(!($entityState == UnitOfWork::STATE_MANAGED || $entityState == UnitOfWork::STATE_DETACHED)) {
			throw new \InvalidArgumentException('Parameter entity harus dalam state managed atau detached', 100, null);
		}
	
		if($entityState == UnitOfWork::STATE_DETACHED) {
			return $this->getEntityManager()->merge($entity);
		}
		return $entity;
	}
}