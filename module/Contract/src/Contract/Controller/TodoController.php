<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Contract\Todo\ContractInitTodoListProvider;

/**
 * Kelas index dari module Contract.
 * Nampilin seluruh todo list terkait manajemen kontrak.
 * 
 * @author zakyalvan
 */
class TodoController extends AbstractActionController {
	const CONTRACT_INIT_TODO_LIST_PROVIDER = 'Contract\Todo\ContractInit';
	const CONTRACT_CREATE_TODO_LIST_PROVIDER = 'Contract\Todo\ContractCreate';
	const CONTRACT_AMEND_TODO_LIST_PROVIDER = 'Contract\Todo\ContractAmend';
	const WORK_ORDER_TODO_LIST_PROVIDER = 'Contract\Todo\WorkOrder';
	const CONTRACT_INVOICE_TODO_LIST_PROVIDER = 'Contract\Todo\ContractInvoice';
	
	private $acceptCriteria = array(
		'Zend\View\Model\ViewModel' => array('text/html'),
		'Zend\View\Model\JsonModel' => array('application/json')
	);
	
	/**
	 * Tampilin todo list untuk seluruh seluruh proses manajemen kontrak.
	 */
	public function indexAction() {
		$pageNumber = $this->params()->fromRoute('page');
		$itemCountPerPage = $this->params()->fromRoute('rows');
		
		/* @var $initTodoListProvider ContractInitTodoListProvider */
		$initTodoListProvider = $this->getServiceLocator()->get(self::CONTRACT_INIT_TODO_LIST_PROVIDER);
		$initTodoListProvider->setContextDatas(array(
				ContractInitTodoListProvider::KODE_FUNGSI_CONTEXT_KEY => '410',
				ContractInitTodoListProvider::KODE_KANTOR_CONTEXT_KEY => '44A'
		));
		
		return array(
			'initTodoList' => $initTodoListProvider->getListData($pageNumber, $itemCountPerPage)
		);
	}
	
	/**
	 * Penyedia data pekerjaan kontrak yang harus diinisiasi/pengadaan yang sudah beres (sudah ada pemenang).
	 */
	public function initiateAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		if($viewModel instanceof JsonModel) {
			
			$viewModel->setVariables($variables);
			return $viewModel;
		}
	}
	
	/**
	 * Penyedia data item pekerjaan dalam proses pembuatan kontrak.
	 * 
	 * @return \Zend\View\Model\JsonModel
	 */
	public function contractAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		if($viewModel instanceof JsonModel) {
				
			return $viewModel;
		}
	}
	
	/**
	 * Peneydia item pekerjaan terkait manajemen perubahan/adendum kontrak.
	 * 
	 * @return \Zend\View\Model\JsonModel
	 */
	public function amendAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		if($viewModel instanceof JsonModel) {
				
			return $viewModel;
		}
	}
	
	/**
	 * Penyedia data list pekerjaan yang harus dilakukan dalam proses manajemen workorder.
	 * 
	 * @return \Zend\View\Model\JsonModel
	 */
	public function workOrderAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		if($viewModel instanceof JsonModel) {
				
			return $viewModel;
		}
	}
	
	public function progressAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		if($viewModel instanceof JsonModel) {
				
			return $viewModel;
		}
	}
	
	/**
	 * Penyedia data item pekerjaan pembuatan dan pemrosesan tagihan (invoice).
	 * 
	 * @return \Zend\View\Model\JsonModel
	 */
	public function invoiceAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		if($viewModel instanceof JsonModel) {
				
			return $viewModel;
		}
	}
	
	private function getTodoListProvider($name) {
		return $this->serviceLocator->get($name);
	}
}