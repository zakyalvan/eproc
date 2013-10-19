<?php
namespace Procurement\Entity\Tender\Repository;

use Doctrine\ORM\EntityRepository;
use Procurement\Entity\Tender\Tender;
use Doctrine\ORM\Query\Expr\Join;
use Application\Entity\Kantor;
use Doctrine\ORM\UnitOfWork;
use Vendor\Entity\Vendor;
use Procurement\Entity\Tender\VendorStatus;
use Procurement\Entity\Status;

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
			->leftJoin('tender.listItem', 'listItem')
			->leftJoin('tender.listTenderVendor', 'listTenderVendor')
			->where($queryBuilder->expr()->eq('tender.kode', ':kodeTender'))
			->setParameter('kodeKantor', $tender->getKantor()->getKode())
			->setParameter('kodeTender', $tender->getKode())
			->getQuery()
			->getSingleResult();
	}
	
	/**
	 * 
	 * @param Tender $tender
	 * @return boolean
	 */
	public function hasTenderWinner(Tender $tender) {
		$tender = $this->ensureManagedEntity($tender);
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		$completedWithWinnerVendor = $queryBuilder->select($queryBuilder->expr()->count('tender.kode'))
			->from('Procurement\Entity\Tender\Tender', 'tender')
			->innerJoin('tender.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->innerJoin('tender.listTenderVendor', 'tenderVendor')
			->innerJoin('tenderVendor.vendorStatus', 'tenderVendorStatus', Join::WITH, $queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('tenderVendorStatus.status', ':kodeStatus'),
				$queryBuilder->expr()->eq('tenderVendorStatus.pemenang', ':pemenang')
			))
			->where($queryBuilder->expr()->eq('tender.kode', ':kodeTender'))
			->setParameter('kodeKantor', $tender->getKantor()->getKode())
			->setParameter('pemenang', VendorStatus::FLAG_PEMENANG)
			->setParameter('kodeStatus', Status::KODE_PENUNJUKAN_PEMENANG)
			->setParameter('kodeTender', $tender->getKode())
			->getQuery()
			->getSingleScalarResult();
		
		return $completedWithWinnerVendor > 0;
	}
	
	/**
	 * Retrieve pemenang tender.
	 * 
	 * @param Tender $tender
	 * @return Vendor
	 */
	public function getTenderWinner(Tender $tender) {
		$tender = $this->ensureManagedEntity($tender);
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select('vendor')
			->from('Vendor\Entity\Vendor', 'vendor')
			->innerJoin('Procurement\Entity\Tender\TenderVendor', 'tenderVendor', Join::WITH, $queryBuilder->expr()->eq('tenderVendor.vendor', 'vendor'))
			->innerJoin('tenderVendor.tender', 'tender', Join::WITH, $queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('tender.kode', ':kodeTender'),
				$queryBuilder->expr()->eq('tender.kantor', ':kodeKantor')
			))
			->innerJoin('tenderVendor.vendorStatus', 'tenderVendorStatus', Join::WITH, $queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('tenderVendorStatus.pemenang', ':pemenang'),
				$queryBuilder->expr()->eq('tenderVendorStatus.status', ':kodeStatus')
			))
			->setParameter('kodeTender', $tender->getKode())
			->setParameter('kodeKantor', $tender->getKantor()->getKode())
			->setParameter('pemenang', VendorStatus::FLAG_PEMENANG)
			->setParameter('kodeStatus', Status::KODE_PENUNJUKAN_PEMENANG)
			->getQuery()
			->getOneOrNullResult();
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