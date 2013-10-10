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

/**
 * Implementasi default dari procurement service.
 * 
 * @author zakyalvan
 */
class ProcurementService implements ProcurementServiceInterface, ServiceLocatorAware {
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
			'fields' => array('kode', 'kantor.kode')
		));
		$valid = $validator->isValid($tenderIdentity);
		
		if(!$valid && $throwException) {
			throw new \InvalidArgumentException(sprintf('Tender dengan kode tender %s dan kode kantor tidak terdaftar dalam database', $tenderIdentity['kode'], $tenderIdentity['kantor.kode']), 100, null);
		}
		return $valid;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Procurement\Service\ProcurementServiceInterface::isCompletedWithWinnerVendor()
	 */
	public function isCompletedWithWinnerVendor($tender) {
		$tenderIdentity = $this->extractTenderIdentity($tender);
		
		if($this->isRegisteredTender($tenderIdentity, true)) {
			/* @var $entityManager EntityManager */
			$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
			
			$completedWithWinnerVendor = $entityManager->createQuery('SELECT COUNT(tender) FROM Procurement\Entity\Tender\Tender tender INNER JOIN tender.kantor kantor INNER JOIN tender.listTenderVendor tenderVendor WITH tenderVendor.pemenang = :pemenang INNER JOIN tenderVendor.status status WITH status.kode = :kodeStatus WHERE tender.kode = :kodeTender AND kantor.kode = :kodeKantor')
				->setParameter('kodeStatus', Status::KODE_PENUNJUKAN_PEMENANG)
				->setParameter('pemenang', TenderVendor::FLAG_PEMENANG)
				->setParameter('kodeTender', $tenderIdentity['kode'])
				->setParameter('kodeKantor', $tenderIdentity['kantor.kode'])
				->getSingleScalarResult();
			
			return $completedWithWinnerVendor ? true : false;
		}
		
		return false;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Procurement\Service\ProcurementServiceInterface::getWinnerVendor()
	 */
	public function getWinnerVendor($tender) {
		$tenderIdentity = $this->extractTenderIdentity($tender);
		
		if(!$this->isCompletedWithWinnerVendor($tenderIdentity)) {
			throw new \InvalidArgumentException(sprintf('Tender dengan kode %s dan kode kantor %s belum selesai dengan pemenang atau selesai tanpa pemenang.'), 100, null);
		}
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		return $entityManager->createQuery('SELECT vendor FROM Procurement\Entity\Tender\Tender tender INNER JOIN tender.kantor kantor INNER JOIN tender.listTenderVendor tenderVendor WITH tenderVendor.pemenang = :pemenang INNER JOIN tenderVendor.vendor vendor INNER JOIN tenderVendor.status status WITH status.kode = :kodeStatus WHERE tender.kode = :kodeTender AND kantor.kode = :kodeKantor')
			->setParameter('kodeStatus', Status::KODE_PENUNJUKAN_PEMENANG)
			->setParameter('pemenang', TenderVendor::FLAG_PEMENANG)
			->setParameter('kodeTender', $tenderIdentity['kode'])
			->setParameter('kodeKantor', $tenderIdentity['kantor.kode'])
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
			$tenderIdentity['kode'] = $tender->getKode();
			$tenderIdentity['kantor.kode'] = $tender->getKantor()->getKode();
		}
		else if(is_array($tender)) {
			// Ini jika sebelumnya pernah di-extract.
			if(count($tender) == 2 && array_key_exists('kode', array_keys($tender)) && array_key_exists('kantor.kode', array_keys($tender))) {
				$tenderIdentity = $tender;
			}
			else {
				foreach (array('kodeTender','kodeKantor') as $key) {
					if(!array_key_exists($key, array_keys($tender))) {
						throw new \InvalidArgumentException(sprintf('Key %s harus diberikan dalam araay sebagai parameter id tender.', $key), 100, null);
					}
					
					if($key == 'kodeTender') {
						$tenderIdentity['kode'] = $tender[$key];
					}
					else if($key == 'kodeKantor') {
						$tenderIdentity['kantor.kode'] = $tender[$key];
					}
				}
			}
		}
		else {
			throw new \InvalidArgumentException(sprintf('Parameter tender harus berupa instance dari Tender atau array dengan key kodeTender dan kodeKantor'), 100, null);
		}
		return $tenderId;
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