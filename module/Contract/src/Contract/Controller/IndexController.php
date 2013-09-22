<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Kelas index dari module Contract.
 * Nampilin seluruh todo list terkait manajemen kontrak.
 * 
 * @author zakyalvan
 */
class IndexController extends AbstractActionController {
	public function indexAction() {
		$initiateTodoListProvider = $this->getServiceLocator()->get('Contract\Todo\InitiateContractTodoListProvider');
		if($initiateTodoListProvider->getObjectManager() == null) {
			exit("Object manager null");
		}
		else {
			exit("Object manager tidak null");
		}
	}
}