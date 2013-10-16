<?php
namespace Procurement\Entity\Tender\Repository;

use Doctrine\ORM\EntityRepository;
use Procurement\Entity\Tender\Tender;
use Doctrine\ORM\Query\Expr\Join;
use Application\Entity\Kantor;

/**
 * Custom repository untuk tender.
 * 
 * @author zakyalvan
 */
class TenderRepository extends EntityRepository {
	/**
	 * Retieve satu object entity tender berdasarkan identitynya.
	 * 
	 * @param unknown $kodeTender
	 * @param unknown $kantor
	 * @return Tender
	 */
	public function findOneByIdentity($kodeTender, $kantor, $extractRelations = false) {
		$kodeKantor = $kantor;
		if($kantor instanceof Kantor) {
			$kodeKantor = $kantor->getKode();
		}
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		$tender = $queryBuilder->select('tender')
			->from($this->getClassMetadata()->getName(), 'tender')
			->innerJoin('tender.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->where($queryBuilder->expr()->eq('tender.kode', ':kodeTender'))
			->setParameter('kodeKantor', $kodeKantor)
			->setParameter('kodeTender', $kodeTender)
			->getQuery()
			->getSingleResult();
		
		if($extractRelations) {
			return $this->extractRelations($tender);
		}
		return $tender;
	}
	
	/**
	 * 
	 * @param Tender $tender
	 * @return Tender
	 */
	public function extractRelations(Tender $tender) {
		$tender = $this->ensureManagedEntity($tender);
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select(array('tender', 'kantor', 'listItem'))
			->from($this->getClassMetadata()->getName(), 'tender')
			->innerJoin('tender.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->innerJoin('tender.listItem', 'listItem')
			->where($queryBuilder->expr()->eq('tender.kode', ':kodeTender'))
			->setParameter('kodeKantor', $tender->getKantor()->getKode())
			->setParameter('kodeTender', $tender->getKode())
			->getQuery()
			->getSingleResult();
	}
	
	protected function ensureManagedEntity($entity) {
		if($entity == null) {
			throw new \InvalidArgumentException('Parameter entity tidak boleh null', 100, null);
		}
		
		$entityState = $this->getEntityManager()->getUnitOfWork()->getEntityState($entity);
		if($entityState != UnitOfWork::STATE_MANAGED || $entityState != UnitOfWork::STATE_DETACHED) {
			throw new \InvalidArgumentException('Parameter entity harus dalam state managed atau detached', 100, null);
		}
	
		if($entityState == UnitOfWork::STATE_DETACHED) {
			return $this->getEntityManager()->merge($entity);
		}
		return $entity;
	}
}