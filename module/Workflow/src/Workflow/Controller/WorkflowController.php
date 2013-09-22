<?php
namespace Workflow\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;

class WorkflowController extends DefinitionActionController {	
	public function indexAction() {		
		$datas = $this->_getDefinitionService()->listWorkflows();
		print_r($datas);
		exit();
		return new ViewModel(array('datas' => $datas));
	}
	
	/**
	 * Tampilin create workflow form.
	 */
	public function createAction() {
		
	}
	
	/**
	 * List seluruh workflow yang available.
	 */
	public function listAction() {
		
	}
	
	/**
	 * Validate workflow.
	 */
	public function validateAction() {
		
	}
	
	/**
	 * Delete workflow, tentu saja beserta dependeninya.
	 */
	public function deleteAction() {
		
	}
}