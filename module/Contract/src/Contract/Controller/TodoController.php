<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Contract\Todo\ContractInitTodoListProvider;
use Contract\Todo\ContractCreateTodoListProvider;
use Zend\Authentication\AuthenticationService;
use Application\Todo\TodoListProviderInterface;
use Application\Security\SecurityContext;

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
		/* @var $securityContext SecurityContext */ 
		$securityContext = $this->identity();
		
		if($securityContext == null) {
			$this->redirect()->toRoute('login');
		}
		
		$pageNumber = $this->params()->fromRoute('page');
		$itemCountPerPage = $this->params()->fromRoute('rows');
		
		/* @var $initTodoListProvider ContractInitTodoListProvider */
		$initTodoListProvider = $this->getTodoListProvider(self::CONTRACT_INIT_TODO_LIST_PROVIDER);
		$initTodoListProvider->setContextDatas(array(
			ContractInitTodoListProvider::KODE_KANTOR_CONTEXT_KEY => $securityContext->getLoggedinUser()->getKantor()->getKode(),
			ContractInitTodoListProvider::KODE_FUNGSI_CONTEXT_KEY => $securityContext->getActiveRole()->getKode()
		));
		
		/* @var $createTodoListProvider ContractCreateTodoListProvider */ 
		$createTodoListProvider = $this->getTodoListProvider(self::CONTRACT_CREATE_TODO_LIST_PROVIDER);
		$createTodoListProvider->setContextDatas(array(
			ContractCreateTodoListProvider::KODE_KANTOR_CONTEXT_KEY => $securityContext->getLoggedinUser()->getKantor()->getKode(),
			ContractCreateTodoListProvider::KODE_ROLE_CONTEXT_KEY => $securityContext->getActiveRole()->getKode(),
			ContractCreateTodoListProvider::KODE_USER_CONTEXT_KEY => $securityContext->getLoggedinUser()->getKode()
		));
		
		$amendTodoListProvider = $this->getTodoListProvider(self::CONTRACT_AMEND_TODO_LIST_PROVIDER);
		
		$workorderTodoListProvider = $this->getTodoListProvider(self::WORK_ORDER_TODO_LIST_PROVIDER);
		
		$invoiceTodoListProvider = $this->getTodoListProvider(self::CONTRACT_INVOICE_TODO_LIST_PROVIDER);
		
		/**
		 * @TODO Pagination ini masih abal-abal, masih dilakukan disisi browser. Fix it!
		 */
		return array(
			'initTodoListProvider' => $initTodoListProvider,
			'createTodoListProvider' => $createTodoListProvider
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
	/**
	 * Penyedia data list pekerjaan pemantauan progress kontrak.
	 * 
	 * @return \Zend\View\Model\JsonModel
	 */
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
	/**
	 * Retrieve todo list object.
	 * 
	 * @param string $name
	 * @return TodoListProviderInterface
	 */
	private function getTodoListProvider($name) {
		return $this->serviceLocator->get($name);
	}
}