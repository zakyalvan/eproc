<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Contract\Service\AbstractContractListProvider;
use Contract\Service\ContractListProviderInterface;

/**
 * Kelas kontroler ini mewakili aktifitas-aktifitas dalam proses flow 
 * C.2 - Pembelian Melalui Kontrak Harga Satuan/Workorder.
 * 
 * @author zakyalvan
 */
class SatuanController extends AbstractActionController {
	private $acceptCriteria = array(
		'Zend\View\Model\JsonModel' => array('application/json')
	);
	
	/**
	 * Handle pemilihan kontrak yang akan dibuatkan wo (kontrak dengan tipe kontrak HARGA SATUAN).
	 */
	public function indexAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		
		/* @var $contractListProvider ContractListProviderInterface */
		$contractListProvider = $this->getServiceLocator()->get(AbstractContractListProvider::KONTRAK_HARGA_SATUAN_LIST_PROVIDER);
		
		$datas = $contractListProvider->getContractList(1, 10);
		print_r($datas->getIterator());
		exit();
		
// 		if($viewModel instanceof JsonModel) {
// 			exit('Hahahaha');
// 			return $viewModel;
// 		}
		
		return array();
	}
	
	/**
	 * Create workorder.
	 */
	public function createAction() {
		return array();
	}
}