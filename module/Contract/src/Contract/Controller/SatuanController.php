<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Contract\Service\AbstractContractListProvider;
use Contract\Service\ContractListProviderInterface as ContractListProvider;

/**
 * Kelas kontroler ini mewakili aktifitas-aktifitas dalam proses flow 
 * C.2 - Pembelian Melalui Kontrak Harga Satuan/Workorder.
 * Sebagai catatan, sebagian aktifitas dalam proses ini ada di modul eksternal.
 * 
 * @author zakyalvan
 */
class SatuanController extends AbstractActionController {
	private $acceptCriteria = array(
		'Zend\View\Model\ViewModel' => array('text/html'),
		'Zend\View\Model\JsonModel' => array('application/json')
	);
	
	/**
	 * Handle pemilihan kontrak yang akan dibuatkan wo (kontrak dengan tipe kontrak HARGA SATUAN).
	 */
	public function indexAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		
 		if($viewModel instanceof JsonModel) {
 			/* @var $contractListProvider ContractListProvider */
 			$contractListProvider = $this->getServiceLocator()->get(AbstractContractListProvider::KONTRAK_HARGA_SATUAN_LIST_PROVIDER);
 			$datas = $contractListProvider->getListData(1, 10);
 			
 			return $viewModel;
 		}
		
		return $viewModel;
	}
	
	/**
	 * Aktifitas pembuatan workorder.
	 */
	public function createAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		
		// Handle penyimpanan data workorder.
		if($this->getRequest()->isPost()) {
			
		}
		
		return array();
	}
	
	/**
	 * Handling seluruh proses approval.
	 */
	public function approvalAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		
		if($this->getRequest()->isPost()) {
			
		}
	}
}