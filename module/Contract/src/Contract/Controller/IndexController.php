<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Kontroller utama.
 * 
 * @author zakyalvan
 */
class IndexController extends AbstractActionController {
	public function indexAction() {
		$this->redirect()->toRoute('contract/default', array('controller' => 'todo', 'action' => 'index'));
	}
}