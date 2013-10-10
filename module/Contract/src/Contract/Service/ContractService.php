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

/**
 * Implementasi default dari {@link ContractServiceInterface}
 * 
 * @author zakyalvan
 */
class ContractService implements ContractServiceInterface, ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * (non-PHPdoc)
	 * @see \Contract\Service\ContractServiceInterface::canCreateContractForTender()
	 */
	public function canCreateContractForTender($tender) {
		
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
	
	public function saveContractDraft(Kontrak $kontrak) {
		
	}
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}