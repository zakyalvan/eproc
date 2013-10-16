<?php
namespace Contract\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Contract\Entity\Kontrak\Kontrak;
use Procurement\Entity\Tender\Tender;
use Procurement\Service\ProcurementServiceInterface;
use Vendor\Entity\Vendor;
use Application\Common\KeyGeneratatorInterface;
use DoctrineModule\Validator\ObjectExists;
use Contract\Entity\Kontrak\Repository\KontrakRepository;
use Procurement\Entity\Tender\Repository\TenderRepository;
use Procurement\Entity\Tender\Item as TenderItem;
use Contract\Entity\Kontrak\Item as KontrakItem;

/**
 * Implementasi default dari {@link ContractServiceInterface}
 * 
 * @author zakyalvan
 */
class ContractService implements ContractServiceInterface, ServiceLocatorAware {
	const KODE_KONTRAK_KEY = 'kode';
	const KODE_KANTOR_KEY = 'kantor.kode';
	
	const ALT_KODE_KONTRAK_KEY = 'kodeKontrak';
	const ALT_KODE_KANTOR_KEY = 'kodeKantor';
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::hasRegisteredContractForTender()
	 */
	public function hasRegisteredContractForTender($tender) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::canCreateContractForTender()
	 */
	public function canCreateContractForTender($tender) {
		/* @var $procurementService ProcurementServiceInterface */
		$procurementService = $this->serviceLocator->get('Procurement\Service\ProcurementService');
		
		if(!$procurementService->isRegisteredTender($tender)) {
			exit("Huhuhu" . get_class($this));
			return false;
		}
		if(!$procurementService->isCompletedWithWinnerVendor($tender)) {
			exit("Hihihi" . get_class($this));
			return false;
		}
		
		
		return true;
	}
	
	public function hasContractForTender($tender) {
		/* @var $procurementService ProcurementServiceInterface */
		$procurementService = $this->serviceLocator->get('Procurement\Service\ProcurementService');
		$tender = $procurementService->getRegisteredTender($tender);
	
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
	
		/* @var $kontrakRepository KontrakRepository */
		$kontrakRepository = $entityManager->getRepository('Contract\Entity\Kontrak\Kontrak');
	
		if($kontrakRepository->countByTender($tender) > 0) {
			return true;
		}
		return false;
	}
	
	/**
	 * Retrieve (atau bikin dan simpan jika belum ada)
	 * 
	 * @param unknown $tender
	 * @throws \InvalidArgumentException
	 * @return \Contract\Entity\Kontrak\Kontrak
	 */
	public function getContractForTender($tender) {
		/* @var $procurementService ProcurementServiceInterface */
		$procurementService = $this->serviceLocator->get('Procurement\Service\ProcurementService');
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$tender = $procurementService->getRegisteredTender($tender);
		
		// Jika sudah terdaftar, ambil yang sudah terdaftar.
		if($this->hasContractForTender($tender)) {
			/* @var $kontrakRepository KontrakRepository */
			$kontrakRepository = $entityManager->getRepository('Contract\Entity\Kontrak\Kontrak');
			return $kontrakRepository->findOneByTender($tender, true);
		}
		// Jika belum terdaftar, bikin baru.
		else {
			if(!$procurementService->isCompletedWithWinnerVendor($tender)) {
				throw new \InvalidArgumentException(sprintf('Tidak dapat membuat kontrak untuk vendor yang diberikan.'), 100, null);
			}
			
			$entityManager->beginTransaction();
			try {
				/* @var $tenderRepository TenderRepository */ 
				$tenderRepository = $entityManager->getRepository('Procurement\Entity\Tender\Tender');
				$tender = $tenderRepository->extractRelations($tender);
				
				/* @var $vendor Vendor */
				$vendor = $procurementService->getWinnerVendor($tender);
				
				/* @var $keyGenerator KeyGeneratatorInterface */
				$keyGenerator = $this->serviceLocator->get('Application\Common\KeyGeneratator');
			
				$kontrak = new Kontrak();
				$kontrak->setKode($keyGenerator->generateNextKey($kontrak, 'kode'));
				$kontrak->setTender($tender);
				$kontrak->setKantor($tender->getKantor());
				$kontrak->setVendor($vendor);
				$kontrak->setNamaVendor($vendor->getNama());
				$kontrak->setTipeKontrak($tender->getTipeKontrak());
				$kontrak->setJudulPekerjaan($tender->getJudulPekerjaan());
				$kontrak->setLingkupPekerjaan($tender->getLingkupPekerjaan());
				$kontrak->setMataUang($tender->getMataUang());
				$kontrak->setTanggalBuat(new \DateTime(null, null));
				$kontrak->setTanggalRekam(new \DateTime(null, null));
				
				$entityManager->persist($kontrak);
				
				foreach ($tender->getListItem() as $itemTender) {
					/* @var $itemTender TenderItem */
					
					$itemKontrak = new KontrakItem();
					$itemKontrak->setKontrak($kontrak);
					$itemKontrak->setHarga($itemTender->getHarga());
					$itemKontrak->setJumlah($itemTender->getJumlah());
					$itemKontrak->setUnit($itemTender->getUnit());
					$itemKontrak->setKeterangan($itemTender->getKeterangan());
					$itemKontrak->setTanggalRekam(new \DateTime(null, null));
					
					$entityManager->persist($itemKontrak);
				}
				
				$entityManager->flush();
				$entityManager->commit();
				
				return $kontrak;
			}
			catch (\Exception $e) {
				$entityManager->rollback();
				throw new \RuntimeException('Pembuatan kontrak baru gagal. Perhatikan stack trace', 100, $e);
			}
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::createContractForTender()
	 */
	public function createContractForTender($tender, $persist = true) {
		/* @var $procurementService ProcurementServiceInterface */
		$procurementService = $this->serviceLocator->get('Procurement\Service\ProcurementService');
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		if(!$procurementService->isCompletedWithWinnerVendor($tender)) {
			throw new \InvalidArgumentException(sprintf('Tidak dapat membuat kontrak untuk vendor yang diberikan.'), 100, null);
		}
		
		/* @var $vendor Vendor */
		$vendor = $procurementService->getWinnerVendor($tender);
		
		/* @var $tender Tender */
		$tender = $entityManager->createQuery('SELECT tender, kantor, listItem FROM Procurement\Entity\Tender\Tender tender INNER JOIN tender.kantor kantor WITH kantor.kode = :kodeKantor INNER JOIN tender.listItem listItem WHERE tender.kode = :kodeTender')
			->setParameter('kodeKantor', $tenderId['KODE_KANTOR'])
			->setParameter('kodeTender', $tenderId['KODE_TENDER'])
			->getSingleResult();
		
		/* @var $keyGenerator KeyGeneratatorInterface */
		$keyGenerator = $this->serviceLocator->get('Application\Common\KeyGeneratator');
		
		$kontrak = new Kontrak();
		$kontrak->setKode($keyGenerator->generateNextKey(get_class($kontrak), 'kode'));
		$kontrak->setTender($tender);
		$kontrak->setKantor($tender->getKantor());
		$kontrak->setVendor($vendor);
		$kontrak->setNamaVendor($vendor->getNama());
		$kontrak->setTipeKontrak($tender->getTipeKontrak());
		$kontrak->setJudulPekerjaan($tender->getJudulPekerjaan());
		$kontrak->setLingkupPekerjaan($tender->getLingkupPekerjaan());
		$kontrak->setMataUang($tender->getMataUang());
		
		/**
		 * TODO Masukin item kontrak dari item pengadaan.
		 */
		
		if($persist) {
			$entityManager->persist($kontrak);
			$entityManager->flush($kontrak);
		}
		
		return $kontrak;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::saveContractDraft()
	 */
	public function saveContractDraft(Kontrak $kontrak) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::isRegisteredContract()
	 */
	public function isRegisteredContract($kontrak) {
		$kontrakIdentity = $this->extractContractIdentity($kontrak);
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$validator = new ObjectExists(array(
			'object_repository' => $entityManager->getRepository('Contract\Entity\Kontrak\Kontrak'),
			'fields' => array('kode', 'kantor.kode')
		));
		$valid = $validator->isValid($kontrakIdentity);
		return $valid;
	}
	
	/**
	 * Ekstrak identity kontrak.
	 */
	protected function extractContractIdentity($kontrak) {
		$kontrakIdentity = array();
		if($kontrak instanceof Kontrak) {
			if($kontrak->getKode() != null && $kontrak->getKantor() != null) {
				$kontrakIdentity[self::KODE_KONTRAK_KEY] = $kontrak->getKode();
				$kontrakIdentity[self::KODE_KANTOR_KEY] = $kontrak->getKantor()->getKode();
			}
			else {
				throw new \InvalidArgumentException('Parameter object kontrak yang diberikan tidak valid, kode kontrak atau object kantor sama dengan null', 100, null);
			}
		}
		else if(is_array($kontrak)) {
			// Jika sebelumnya pernah diekstrak.
			if(array_key_exists(self::KODE_KONTRAK_KEY, $kontrak) && array_key_exists(self::KODE_KANTOR_KEY, $kontrak)) {
				$kontrakIdentity[self::KODE_KONTRAK_KEY] = $kontrak[self::KODE_KONTRAK_KEY];
				$kontrakIdentity[self::KODE_KANTOR_KEY] = $kontrak[self::KODE_KANTOR_KEY];
			}
			else if(array_key_exists(self::ALT_KODE_KONTRAK_KEY, $kontrak) && array_key_exists(self::ALT_KODE_KANTOR_KEY, $kontrak)) {
				$kontrakIdentity[self::KODE_KONTRAK_KEY] = $kontrak[self::ALT_KODE_KONTRAK_KEY];
				$kontrakIdentity[self::KODE_KANTOR_KEY] = $kontrak[self::ALT_KODE_KONTRAK_KEY];
			}
			else {
				throw new \InvalidArgumentException('Parameter array identity kontrak yang diberikan tidak valid, key yang dibutuhkan %s atay %stidak ada.', 100, null);
			}
		}
		else {
			throw new \InvalidArgumentException('Parameter kontrak harus berupa object instance dari kelas Contract\Entity\Kontrak\Kontrak atau array dengan key kodeKontrak, kodeKantor', 100, null);
		}
		return $kontrakIdentity;
	}
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}