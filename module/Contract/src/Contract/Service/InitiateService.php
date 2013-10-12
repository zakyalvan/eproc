<?php
namespace Contract\Service;

use Contract\Entity\PenunjukanPengelola;
use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Application\Todo\Exception\RuntimeException;
use Workflow\Execution\ExecutionServiceInterface;
use Application\Common\KeyGeneratatorInterface;
use Workflow\Definition\DefinitionServiceInterface;

/**
 * Implementasi default 
 * 
 * @author zakyalvan
 */
class InitiateService implements InitiateServiceInterface, ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function savePenunjukanPengelola(PenunjukanPengelola $penujukanPengelola) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$entityManager->beginTransaction();
		try {
			/* @var $keyGenerator KeyGeneratatorInterface */
			$keyGenerator = $this->serviceLocator->get('Application\Common\KeyGeneratator');
			
			$penujukanPengelola->setKode($keyGenerator->generateNextKey($penujukanPengelola, 'kode'));
			$entityManager->persist($penujukanPengelola);
			
			/* @var $definitionService DefinitionServiceInterface */
			$definitionService = $this->serviceLocator->get('Workflow\Definition\DefinitionService');
			$workflow = $definitionService->getWorkflow(1);
			$instanceDatas = array(
				'KODE_TENDER' => $penujukanPengelola->getTender()->getKode(),
				'KODE_KANTOR' => $penujukanPengelola->getTender()->getKantor()->getKode(),
				//'PENGELOLA_KONTRAK' => $penujukanPengelola->getUserPengelola()->getKode()
			);
			
			/* @var $executionService ExecutionServiceInterface */
			$executionService = $this->serviceLocator->get('Workflow\Execution\ExecutionService');
			
			$executionService->startWorkflow($workflow, $instanceDatas);
			$entityManager->commit();
		}
		catch (\Exception $e) {
			$entityManager->rollback();
			throw new RuntimeException('Penyimpanan data penunjukan pengelola kontrak gagal, eksepsi dalam proses penyimpanan.', 100, $e);
		}
	}
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}