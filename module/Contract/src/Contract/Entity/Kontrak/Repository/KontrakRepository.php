<?php
namespace Contract\Entity\Kontrak\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Procurement\Entity\Tender\Tender;
use Doctrine\ORM\UnitOfWork;
use Application\Entity\Kantor;
use Contract\Entity\Kontrak\Kontrak;

/**
 * Custom repository untuk entity Kontrak.
 * 
 * @author zakyalvan
 */
class KontrakRepository extends EntityRepository {
	/**
	 * Hitung jumlah kontrak berdasarkan tender.
	 * 
	 * @param Tender $tender
	 * @return integer
	 */
	public function countByTender(Tender $tender) {
		$tender = $this->ensureManagedEntity($tender);
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$count = $queryBuilder->select($queryBuilder->expr()->count('kontrak.kode'))
			->from($this->_class->getName(), 'kontrak')
			->innerJoin('kontrak.tender', 'tender', Join::WITH, $queryBuilder->expr()->eq('tender.kode', ':kodeTender'))
			->innerJoin('kontrak.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->setParameter('kodeTender', $tender->getKode())
			->setParameter('kodeKantor', $tender->getKantor()->getKode())
			->getQuery()
			->getSingleScalarResult();
		
		return $count;
	}
	
	/**
	 * Retrive satu kontrak berdasarkan 
	 * 
	 * @param Tender $tender
	 * @return Kontrak
	 */
	public function findOneByTender(Tender $tender, $extractRelations = false) {
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		$kontrak = $queryBuilder->select('kontrak', 'tender')
			->from($this->getClassMetadata()->getName(), 'kontrak')
			->innerJoin('kontrak.tender', 'tender', Join::WITH, $queryBuilder->expr()->eq('tender.kode', ':kodeTender'))
			->innerJoin('kontrak.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->setParameter('kodeTender', $tender->getKode())
			->setParameter('kodeKantor', $tender->getKantor()->getKode())
			->getQuery()
			->getOneOrNullResult();
		
		if($kontrak != null && $extractRelations) {
			$kontrak = $this->extractRelations($kontrak);
		}
		return $kontrak;
	}
	
	/**
	 * Retrieve satu entity kontrak berdasarkan identitynya.
	 * 
	 * @param string $kodeKontrak
	 * @param string $kantor
	 * @return Kontrak
	 */
	public function getOneByIdentity($kodeKontrak, $kantor, $extractRelations = false) {
		$kodeKantor = $kantor;
		if($kantor instanceof Kantor) {
			$kodeKantor = $kantor->getKode();
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$kontrak = $queryBuilder->select('kontrak')
			->from($this->_class->getName(), 'kontrak')
			->innerJoin('kontrak.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->where($queryBuilder->expr()->eq('kontrak.kode', ':kodeKontrak'))
			->setParameter('kodeKontrak', $kodeKontrak)
			->setParameter('kodeKantor', $kodeKantor)
			->getQuery()
			->getSingleResult();
		
		if($extractRelations) {
			return $this->extractRelations($kontrak);
		}
		return $kontrak;
	}
	
	/**
	 * Extract relation dari kontrak (one to one, one to many dan many to one).
	 * 
	 * @param Kontrak $kontrak
	 * @return Kontrak
	 */
	public function extractRelations(Kontrak $kontrak) {
		$kontrak = $this->ensureManagedEntity($kontrak);
		
		$queryBuilder = $this->_em->createQueryBuilder();
		return $queryBuilder->select(array('kontrak', 'kantor', 'vendor', 'mataUang', 'listItem', 'listMilestone', 'listDokumen', 'listKomentar'))
			->from($this->getClassMetadata()->getName(), 'kontrak')
			->innerJoin('kontrak.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->leftJoin('kontrak.vendor', 'vendor')
			->leftJoin('kontrak.mataUang', 'mataUang')
			->leftJoin('kontrak.listItem', 'listItem')
			->leftJoin('kontrak.listMilestone', 'listMilestone')
			->leftJoin('kontrak.listDokumen', 'listDokumen')
			->leftJoin('kontrak.listKomentar', 'listKomentar')
			->where($queryBuilder->expr()->eq('kontrak.kode', ':kodeKontrak'))
			->setParameter('kodeKontrak', $kontrak->getKode())
			->setParameter('kodeKantor', $kontrak->getKantor()->getKode())
			->getQuery()
			->getSingleResult();
	}
	
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