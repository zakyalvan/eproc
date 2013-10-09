<?php
namespace Contract\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Contract\Entity\Kontrak\Kontrak;
use Procurement\Entity\Tender\Tender;

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
	 * @see \Contract\Service\ContractServiceInterface::createNewContractForTender()
	 */
	public function createContractForTender($tender) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$tenderId = $this->extractIdentityAndValidateCreateContractForTender($tender);
		if(!$tenderId) {
			throw new \InvalidArgumentException('Tidak dapat membuat kontrak dari tender yang diberikan, data tender tidak ditemukan dalam database', 10, null);
		}
		
		/* @var $tender Tender */
		$tender = $entityManager->createQuery('SELECT tender, kantor FROM Procurement\Entity\Tender\Tender tender INNER JOIN tender.kantor kantor WITH kantor.kode = :kodeKantor WHERE tender.kode = :kodeTender')
			->setParameter('kodeKantor', $tenderId['KODE_KANTOR'])
			->setParameter('kodeTender', $tenderId['KODE_TENDER'])
			->getSingleResult();
		
		$kontrak = new Kontrak();
		$kontrak->setTender($tender);
		$kontrak->setKantor($tender->getKantor());
		$kontrak->setTipeKontrak($tender->getTipeKontrak());
		$kontrak->setJudulPekerjaan($tender->getJudulPekerjaan());
		$kontrak->setLingkupPekerjaan($tender->getLingkupPekerjaan());
		$kontrak->getMataUang($tender->getMataUang());
		
		$entityManager->persist($kontrak);
		
		return $kontrak;
	}
	
	/**
	 * 
	 * @param Tender|array $tender
	 * @return array
	 */
	protected function extractIdentityAndValidateCreateContractForTender($tender) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$tenderId = array();
		if($tender != null && $tender instanceof Tender && $tender->getKode() !=null && $tender->getKantor() != null) {
			$tenderId['KODE_TENDER'] = $tender->getKode();
			$tenderId['KODE_KANTOR'] = $tender->getKantor()->getKode();
		}
		else if($tender != null && is_array($tender)) {
			foreach ($tender as $key => $value) {
				$key = strtoupper($key);
				$requiredKeys = array('KODE_TENDER', 'KODE_KANTOR');
				if(!array_key_exists($key, $requiredKeys)) {
					throw new \InvalidArgumentException(sprintf('Parameter tender yang diberikan tidak sesuai dengan yg dibutuhkan. Key yang dubutuhkan dalam parameter %s', implode(', ', $requiredKeys)), 100, null);
				}
		
				$tenderId[$key] = $value;
			}
		}
		else {
			throw new \InvalidArgumentException(sprintf('Parameter harus berupa instance dari kelas tender atau array dengan key KODE_TENDER dan KODE_KANTOR'), 100, null);
		}
		
		$validTender = $entityManager->createQuery('SELECT EXISTS(tender) FROM Procurement\Entity\Tender\Tender tender INNER JOIN tender.kantor kantor WITH kantor.kode = :kodeKantor WHERE tender.kode = :kodeTender')
			->setParameter('kodeKantor', $tenderId['KODE_KANTOR'])
			->setParameter('kodeTender', $tenderId['KODE_TENDER'])
			->getSingleScalarResult();
		
		return $validTender ? $tenderId : $validTender;
	}
	
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}