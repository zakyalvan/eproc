<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Procurement\Service\ProcurementServiceInterface;
use Contract\Service\ContractServiceInterface;
use Procurement\Service\ProcurementService;
use Zend\Http\Response as HttpResponse;
use Zend\Json\Json;
use Application\Service\ApplicationService;
use Application\Service\ApplicationServiceInterface;
use Application\Entity\Role;
use Contract\Form\AssignPengelolaForm;
use Contract\Entity\PenunjukanPengelola;
use Contract\Form\PenunjukanPengelolaKontrakForm;
use Contract\Service\InitiateServiceInterface;

/**
 * Controller yang ngehandle inisiasi kontrak.
 * Intinya cuma ada satu yaitu assign pengelola kontrak.
 * 
 * @author zakyalvan
 */
class InitController extends AbstractActionController {
	private $acceptCriteria = array(
		'Zend\View\Model\ViewModel' => array('text/html'),
		'Zend\View\Model\JsonModel' => array('application/json')
	);
	
	/**
	 * Handle assign pengelola kontrak untuk sebuah tender tertentu.
	 * Syaratnya :
	 * 1. Tender valid, teregister didatabase tender.
	 * 2. Tender sudah berakhir dan ada pemenang.
	 * 3. Kontrak untuk tender tersebut belum ada didatabase kontrak.
	 */
	public function assignAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		
		$kodeKantor = $this->params()->fromRoute('kantor', '44A');
		$kodeTender = $this->params()->fromRoute('tender');
		
		$tenderIdentity = array('kodeTender' => $kodeTender, 'kodeKantor' => $kodeKantor);
		
		/* @var $procurementService ProcurementServiceInterface */
		$procurementService = $this->serviceLocator->get('Procurement\Service\ProcurementService');
		if(!$procurementService->isRegisteredTender($tenderIdentity)) {
			throw new \InvalidArgumentException(sprintf('Tender dengan identity %s tidak ditemukan dalam database', Json::encode($tenderIdentity)), 100, null);
		}
		
		if(!$procurementService->isCompletedWithWinnerVendor($tenderIdentity)) {
			throw new \InvalidArgumentException(sprintf('Tender dengan identity %s tidak complete dengan vendor pemenang', Json::encode($tenderIdentity)), 100, null);
		}
		
		$tender = $procurementService->getRegisteredTender($tenderIdentity);
		$vendor = $procurementService->getWinnerVendor($tenderIdentity);
		
		/* @var $contractService ContractServiceInterface */
		$contractService = $this->serviceLocator->get('Contract\Service\ContractService');
		if(!$contractService->canCreateContractForTender($tender)) {
			throw new \InvalidArgumentException('Tidak dapat membuat kontrak dari informasi yang diberikan (kodeTender : %s dan kodeKantor : %s)', 100, null);
		}
		
		/* @var $applicationService ApplicationServiceInterface */
		$applicationService = $this->serviceLocator->get('Application\Service\ApplicationService');
		$listPengelolaKontrak = $applicationService->getListUserByRole(Role::KODE_PELAKSANA_KONTRAK, $kodeKantor);
		
		$penunjukanForm = new PenunjukanPengelolaKontrakForm($this->getServiceLocator());
		$penunjukanForm->setListPengelolaKontrak($listPengelolaKontrak);
		
		// Handle jika request adalah post.
		if($this->request->isPost()) {
			$datas = $this->request->getPost();
			
			$penunjukanPengelola = new PenunjukanPengelola();
			$penunjukanPengelola->setUserPenunjuk($this->identity()->getLoggedinUser());
			$penunjukanPengelola->setTender($tender);
			$penunjukanPengelola->setTanggalRekam(new \DateTime());
			$penunjukanPengelola->setPetugasRekam($this->identity()->getLoggedinUser()->getKode());
			
			$penunjukanForm->setObject($penunjukanPengelola);
			$penunjukanForm->setData($datas);
			
			if($penunjukanForm->isValid()) {
				/* @var $initService InitiateServiceInterface */ 
				$initService = $this->serviceLocator->get('Contract\Service\InitiateService');
				
				$initService->savePenunjukanPengelola($penunjukanForm->getObject());
				
				// Kembali lagi ke todo list kontrak.
				$this->redirect()->toRoute('contract/todo');
			}
		}
		
		return array(
			'tender' => $tender,
			'vendor' => $vendor,
			'penunjukanForm' => $penunjukanForm
		);
	}
}