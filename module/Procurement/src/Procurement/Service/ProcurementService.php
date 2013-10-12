<?php
namespace Procurement\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Procurement\Entity\Tender\Tender;
use Zend\Validator\InArray;
use DoctrineModule\Validator\ObjectExists;
use Procurement\Service\Exception\TenderNotCompletedException;
use Procurement\Entity\Status;
use Procurement\Entity\Tender\TenderVendor;
use Zend\Json\Json;
use Doctrine\ORM\Query\Expr\Join;
use Procurement\Entity\Tender\VendorStatus;

/**
 * Implementasi default dari procurement service.
 * 
 * @author zakyalvan
 */
class ProcurementService implements ProcurementServiceInterface, ServiceLocatorAware {
	const KODE_TENDER_KEY = 'kode';
	const KODE_KANTOR_KEY = 'kantor';
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * (non-PHPdoc)
	 * @see \Procurement\Service\ProcurementServiceInterface::isRegisteredTender()
	 */
	public function isRegisteredTender($tender, $throwException = false) {
		$tenderIdentity = $this->extractTenderIdentity($tender);
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$validator = new ObjectExists(array(
			'object_repository' => $entityManager->getRepository('Procurement\Entity\Tender\Tender'), 
			'fields' => array(self::KODE_TENDER_KEY, self::KODE_KANTOR_KEY)
		));
		$valid = $validator->isValid($tenderIdentity);
		
		if(!$valid && $throwException) {
			throw new \InvalidArgumentException(sprintf('Tender dengan kode tender %s dan kode kantor tidak terdaftar dalam database', $tenderIdentity['kode'], $tenderIdentity['kantor.kode']), 100, null);
		}
		return $valid;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Procurement\Service\ProcurementServiceInterface::getRegisteredTender()
	 */
	public function getRegisteredTender($tender) {
		$tenderIdentity = $this->extractTenderIdentity($tender);
		
		if(!$this->isRegisteredTender($tenderIdentity)) {
			throw new \InvalidArgumentException('Identity tender yang diberikan tidak valid, data tender tidak ditemukan dalam database', 100, null);
		}
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		$queryBuilder = $entityManager->createQueryBuilder();
		
		/* @var $tender Tender */
		$tender = $queryBuilder->select(array('tender', 'kantor', 'items'))
			->from('Procurement\Entity\Tender\Tender', 'tender')
			->innerJoin('tender.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->innerJoin('tender.listItem', 'items')
			->where($queryBuilder->expr()->eq('tender.kode', ':kodeTender'))
			->setParameter('kodeKantor', $tenderIdentity[self::KODE_KANTOR_KEY])
			->setParameter('kodeTender', $tenderIdentity[self::KODE_TENDER_KEY])
			->getQuery()
			->getSingleResult();
		
		return $tender;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Procurement\Service\ProcurementServiceInterface::isCompletedWithWinnerVendor()
	 */
	public function isCompletedWithWinnerVendor($tender) {
		$tenderIdentity = $this->extractTenderIdentity($tender);
		
		if(!$this->isRegisteredTender($tenderIdentity, true)) {
			throw new \InvalidArgumentException(sprintf('Parameter tender yang diberikan tidak valid, tender dengan identity tidak ditemukan.', Json::encode($tenderIdentity)), 100, null);
		}
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
			
			
		$queryBuilder = $entityManager->createQueryBuilder();
		$completedWithWinnerVendor = $queryBuilder->select($queryBuilder->expr()->count('tender.kode'))
			->from('Procurement\Entity\Tender\Tender', 'tender')
			->innerJoin('tender.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->innerJoin('tender.listTenderVendor', 'tenderVendor')
			->innerJoin('tenderVendor.vendorStatus', 'tenderVendorStatus', Join::WITH, $queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('tenderVendorStatus.status', ':kodeStatus'),
				$queryBuilder->expr()->eq('tenderVendorStatus.pemenang', ':pemenang')
			))
			->where($queryBuilder->expr()->eq('tender.kode', ':kodeTender'))
			->setParameter('kodeKantor', $tenderIdentity[self::KODE_KANTOR_KEY])
			->setParameter('pemenang', VendorStatus::FLAG_PEMENANG)
			->setParameter('kodeStatus', Status::KODE_PENUNJUKAN_PEMENANG)
			->setParameter('kodeTender', $tenderIdentity[self::KODE_TENDER_KEY])
			->getQuery()
			->getSingleScalarResult();
		
		return $completedWithWinnerVendor;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Procurement\Service\ProcurementServiceInterface::getWinnerVendor()
	 */
	public function getWinnerVendor($tender) {
		$tenderIdentity = $this->extractTenderIdentity($tender);
		
		if(!$this->isCompletedWithWinnerVendor($tenderIdentity)) {
			throw new \InvalidArgumentException(sprintf('Tender dengan identity %s belum selesai dengan pemenang atau selesai tanpa pemenang.', Json::encode($tenderIdentity)), 100, null);
		}
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		$queryBuilder = $entityManager->createQueryBuilder();
		
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
			->setParameter('kodeTender', $tenderIdentity[self::KODE_TENDER_KEY])
			->setParameter('kodeKantor', $tenderIdentity[self::KODE_KANTOR_KEY])
			->setParameter('pemenang', VendorStatus::FLAG_PEMENANG)
			->setParameter('kodeStatus', Status::KODE_PENUNJUKAN_PEMENANG)
			->getQuery()
			->getSingleResult();
	}
	
	/**
	 * Extract tender identity.
	 * 
	 * @param unknown $tender
	 * @throws \InvalidArgumentException
	 * @return multitype:\Procurement\Entity\Tender\Tender string NULL
	 */
	protected function extractTenderIdentity($tender) {
		$tenderIdentity = array();
		if($tender instanceof Tender) {
			$tenderIdentity[self::KODE_TENDER_KEY] = $tender->getKode();
			$tenderIdentity[self::KODE_KANTOR_KEY] = $tender->getKantor()->getKode();
		}
		else if(is_array($tender)) {
			// Ini jika sebelumnya pernah di-extract.
			if(count($tender) == 2 && array_key_exists(self::KODE_TENDER_KEY, $tender) && array_key_exists(self::KODE_KANTOR_KEY, $tender)) {
				$tenderIdentity = $tender;
			}
			else {
				foreach (array('kodeTender','kodeKantor') as $key) {
					if(!array_key_exists($key, $tender)) {
						throw new \InvalidArgumentException(sprintf('Key %s harus diberikan dalam array sebagai parameter identity tender. Yang diberikan %s', $key, implode(', ', array_keys($tender))), 100, null);
					}
					
					if($key == 'kodeTender') {
						$tenderIdentity[self::KODE_TENDER_KEY] = $tender[$key];
					}
					else if($key == 'kodeKantor') {
						$tenderIdentity[self::KODE_KANTOR_KEY] = $tender[$key];
					}
				}
			}
		}
		else {
			throw new \InvalidArgumentException(sprintf('Parameter tender harus berupa instance dari Tender atau array dengan key kodeTender dan kodeKantor'), 100, null);
		}
		return $tenderIdentity;
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