<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Contract\Service\ContractService;
use Contract\Form\DelegateCreationForm;
use Contract\Form\Kontrak\PembuatanForm;
use Contract\Entity\Kontrak\Kontrak;
use Contract\Entity\Kontrak\Komentar;
use Workflow\Execution\ExecutionServiceInterface;
use Workflow\Definition\DefinitionServiceInterface;
use Workflow\Execution\ExecutionService;

/**
 * Kelas kontroler ini mewakili aktifitas-aktifitas dalam proses flow 
 * C.1 - Pembuatan Kontrak.
 * 
 * @author zakyalvan
 */
class CreateController extends AbstractActionController {
	private $acceptCriteria = array(
		'Zend\View\Model\ViewModel' => array('text/html'),
		'Zend\View\Model\JsonModel' => array('application/json')
	);
	
	/**
	 * List draft kontrak.
	 */
	public function indexAction() {
		
	}
	
	/**
	 * Delegasikan pembuatan kontrak kepada bawahan.
	 * Disinilah workflow instance untuk pembuatan kontrak dimulai.
	 */
	public function delegateAction() {
		
		
		if($this->getRequest()->isPost()) {
			
		}
		
		// Render form delegate, tampilin data pengadaan yang akan dibuatkan kontraknya.
		return array(
			
		);
	}
	
	/**
	 * Pembuatan draft kontrak baru
	 */
	public function draftAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		
		$kodeTender = $this->params()->fromRoute('tender');
		$kodeKantor = $this->params()->fromRoute('kantor');
		
		$instance = $this->params()->fromRoute('instance');
		$workitem = $this->params()->fromRoute('workitem');
		$workflow = 'PEMBUATAN_KONTRAK';
		
		
		
		$form = new PembuatanForm($this->getServiceLocator());
		$form->setValidationGroup(array('kontrak' => array()));
		
		$kontrak = $this->contractService()->getContractForTender(array('kodeTender' => $kodeTender, 'kodeKantor' => $kodeKantor));
		$form->bind($kontrak);
		
		if($this->request->isPost()) {
			$form->setData($this->request->getPost());
			if($form->isValid()) {
				$kontrak = $this->contractService()->saveDraft($form->getData());
				
				$workflow = $this->definitionService()->getWorkflow('PEMBUATAN_KONTRAK');
				$executionDatas = array(
					'JENIS_KONTRAK' => $kontrak->getJenisKontrak()
				);
				
				

				$this->redirect()->toRoute('contract/todo');
			}
		}
		
		// Render form create draft kontrak.
		return array(
			'pageTitle' => 'Draft Kontrak',
			'kontrak' => $kontrak,
			'form' => $form
		);
	}
	
	/**
	 * Review draft kontrak, aktifitas ini akan dilakuakan oleh user
	 * setelah proses pembuatan draft kontrak baru (jika type kontrak adalah perjanjian).
	 */
	public function reviewAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		
		$form = new PembuatanForm($this->getServiceLocator());
		
		$kodeTender = $this->params()->fromRoute('tender');
		$kodeKantor = $this->params()->fromRoute('kantor');
		
		// Proses input data draft kontrak dari user.
		if($this->request->isPost()) {
			$form->setData($this->request->getPost());
			
			// Jika form yang disubmit valid, simpan draft kontrak.
			if($form->isValid()) {
				$this->redirect()->toRoute('contract/todo');
			}
		}
		
		// Render form create draft kontrak.
		return array(
			'pageTitle' => 'Review Kontrak',
			'kontrak' => $kontrak,
			'form' => $form
		);
	}
	
	/**
	 * Approval yang harus dilakukan setelah proses review draft kontrak oleh user dilakukan.
	 */
	public function approvalAction() {
		// Render informasi dan form approval draft kontrak.
		return array(
			"pageTitle" => "Kontrak - Persetujuan Draft"
		);
	}
	
	/**
	 * Pembuatan kbh setelah draft kontrak di setujui.
	 */
	public function kbhAction() {
		// Render informasi dan form approval draft kontrak.
		return array(
			"pageTitle" => "Pembuatan KBH",
		);
	}
	
	/**
	 * Aktifitas terakhir finalisasi/inisiasi kontrak setelah draft kontrak 
	 * disetujui (jika type kontrak adalah perjanjian) atau setelah pembuatan draft kontrak,
	 * jika type kontrak adalah spk.
	 */
	public function finalizeAction() {
		
		// Render informasi dan form inisiasi kontrak.
		return array(
			"pageTitle" => "Finalisasi Kontrak"
		);
	}
	
	/**
	 * @return ContractService
	 */
	public function contractService() {
		return $this->getServiceLocator()->get('Contract\Service\ContractService');
	}
	
	/**
	 * @return DefinitionServiceInterface
	 */
	protected function definitionService() {
		return $this->serviceLocator->get('Workflow\Definition\DefinitionService');
	}
	
	/**
	 * @return ExecutionServiceInterface
	 */
	protected function executionService() {
		return $this->serviceLocator->get('Workflow\Execution\ExecutionService');
	}
}