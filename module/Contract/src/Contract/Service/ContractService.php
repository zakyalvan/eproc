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
use DoctrineModule\Validator\ObjectExists as ObjectExistsValidator;
use Contract\Entity\Kontrak\Repository\KontrakRepository;
use Procurement\Entity\Tender\Repository\TenderRepository;
use Procurement\Entity\Tender\Item as TenderItem;
use Contract\Entity\Kontrak\Item as KontrakItem;
use Contract\Entity\Kontrak\Dokumen;
use Application\Common\KeyGeneratorInterface;
use Doctrine\ORM\UnitOfWork;
use Contract\Entity\Kontrak\Item;
use Contract\Entity\Kontrak\Milestone;
use Zend\Authentication\AuthenticationService;
use Application\Security\SecurityContext;
use Contract\Entity\Kontrak\Komentar;
use Workflow\Execution\ExecutionService;
use Workflow\Execution\ExecutionServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;

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
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::hasContractForTender()
	 */
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
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::getContractForTender()
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
				
				$kontrak = $entityManager->merge($kontrak);
				
				foreach ($tender->getListItem() as $itemTender) {
					/* @var $itemTender TenderItem */
					$itemKontrak = new KontrakItem();
					$itemKontrak->setKontrak($kontrak);
					$itemKontrak->setHarga($itemTender->getHarga());
					$itemKontrak->setJumlah($itemTender->getJumlah());
					$itemKontrak->setUnit($itemTender->getUnit());
					$itemKontrak->setKeterangan($itemTender->getKeterangan());
					$itemKontrak->setTanggalRekam(new \DateTime(null, null));
					
					$itemKontrak = $entityManager->merge($itemKontrak);
					$kontrak->getListItem()->add($itemKontrak);
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
	 * @see \Contract\Service\ContractServiceInterface::saveDraft()
	 */
	public function saveDraft(Kontrak $kontrak, $final) {
		$this->entityManager()->beginTransaction();
		try {
			$this->persistKontrak($kontrak);
			$this->entityManager()->commit();
		}
		catch(\Exception $e) {
			$this->entityManager()->rollback();
			throw new \RuntimeException('Terjadi exception dalam proses penyimpanan draft kontrak. Perhatikan eksespi penyimpanan.', 100, $e);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::setApproval()
	 */
	public function setApproval(Kontrak $kontrak, $approval) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::createBkh()
	 */
	public function createBkh(Kontrak $kontrak, $final) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::finalizeDraft()
	 */
	public function finalizeDraft(Kontrak $kontrak, $final) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::isRegisteredContract()
	 */
	public function isRegisteredContract($kontrak) {
		$kontrakIdentity = $this->extractContractIdentity($kontrak);
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$validator = new ObjectExistsValidator(array(
			'object_repository' => $entityManager->getRepository('Contract\Entity\Kontrak\Kontrak'),
			'fields' => array('kode', 'kantor.kode')
		));
		$valid = $validator->isValid($kontrakIdentity);
		return $valid;
	}
	
	/**
	 * Simpan data object kontrak tentu saja dengan dependenciesnya.
	 * 
	 * @param Kontrak $kontrak
	 */
	protected function persistKontrak(Kontrak $kontrak) {
		$entityManager = $this->entityManager();
		
		/* @var $milestone Milestone */
// 		foreach ($kontrak->getListMilestone() as $milestone) {
// 			$milestoneState = $entityManager->getUnitOfWork()->getEntityState($milestone);
// 			if($milestoneState == UnitOfWork::STATE_NEW) {
// 				$milestone->setKode($this->keyGenerator()->generateNextKey($milestone, 'kode'));
// 				$milestone->setKontrak($kontrak);
// 				$milestone->setTanggalRekam(new \DateTime(null, null));
					
// 				if($this->identity()) {
// 					$milestone->setPetugasRekam($this->identity()->getLoggedinUser()->getKode());
// 				}
// 				$entityManager->persist($milestone);
// 			}
// 			else if($milestoneState == UnitOfWork::STATE_MANAGED || $milestoneState == UnitOfWork::STATE_DETACHED){
// 				$milestoneChangeset = $entityManager->getUnitOfWork()->getEntityChangeSet($milestone);
// 				if($milestoneChangeset) {
// 					$entityManager->merge($milestone);
// 				}
// 			}
				
// 		}
			
// 		/* @var $dokumen Dokumen */
// 		foreach ($kontrak->getListDokumen() as $dokumen) {
// 			$dokumenState = $entityManager->getUnitOfWork()->getEntityState($dokumen);
// 			if($dokumenState = UnitOfWork::STATE_NEW) {
// 				$dokumen->setKode($this->keyGenerator()->generateNextKey($dokumen, 'kode'));
// 				$dokumen->setKontrak($kontrak);
// 				$dokumen->setTanggalRekam(new \DateTime(null, null));
// 				$entityManager->persist($dokumen);
// 			}
// 			else if($dokumenState == UnitOfWork::STATE_MANAGED || UnitOfWork::STATE_DETACHED) {
// 				$dokumenChangeset = $entityManager->getUnitOfWork()->getEntityChangeSet($dokumen);
// 				if($dokumenChangeset) {
// 					$dokumen->setTanggalUbah(new \DateTime(null, null));
// 					$entityManager->merge($dokumen);
// 				}
// 			}
// 		}
			
// 		/* @var $item Item */ 
// 		foreach ($kontrak->getListItem() as $item) {
// 			$itemState = $entityManager->getUnitOfWork()->getEntityState($item);
// 			if($itemState == UnitOfWork::STATE_NEW) {
// 				$item->setKontrak($kontrak);
// 				$item->setTanggalRekam(new \DateTime(null, null));
// 				$entityManager->persist($item);
// 			}
// 		}
			
// 		/* @var $komentar Komentar */ 
// 		foreach ($kontrak->getListKomentar() as $komentar) {
// 			// Hanya komentar baru yang disimpan.
// 			if($entityManager->getUnitOfWork()->getEntityState($komentar) == UnitOfWork::STATE_NEW) {
// 				$komentar->setKode($this->keyGenerator()->generateNextKey($komentar, 'kode'));
// 				$komentar->setKontrak($kontrak);
// 				$komentar->setTanggalRekam(new \DateTime(null, null));
// 				$entityManager->persist($komentar);
// 			}
// 		}

		$entityManager->persist($kontrak);
		$entityManager->flush();
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
	
	/**
	 * Retrieve object entity manager dari service locator.
	 * 
	 * @var EntityManager
	 */
	protected function entityManager() {
		return $this->serviceLocator->get('Doctrine\ORM\EntityManager');
	}
	
	/**
	 * Retrieve object key generator dari service locator.
	 * 
	 * @return KeyGeneratorInterface
	 */
	protected function keyGenerator() {
		return $this->serviceLocator->get('Application\Common\KeyGeneratator');
	}
	
	/**
	 * Untuk kasus internal, maka object dalam identity adalah instance dari kelas {@link SecurityContext}
	 * 
	 * @return SecurityContext
	 */
	protected function identity() {
		/* @var $authService AuthenticationService */ 
		$authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
		if($authService->hasIdentity()) {
			return $authService->getIdentity();
		}
		return null;
	}
	
	/**
	 * @return ExecutionServiceInterface
	 */
	protected function executionService() {
		return $this->serviceLocator->get('Workflow\Execution\ExecutionService');
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