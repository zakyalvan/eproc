<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Controller untuk service-service terhadap browser.
 * 
 * @author zakyalvan
 */
class ServiceController extends AbstractActionController {
	private $acceptCriteria = array(
		'Zend\View\Model\JsonModel' => array('application/json')
	);
	
	public function serverTimeAction() {
		$viewModel = $this->acceptableViewModelSelector($this->acceptCriteria);
		
		if($viewModel instanceof JsonModel) {
			$viewModel->setVariable('tanggal', date('d M Y'));
			$viewModel->setVariable('waktu', date('H:i:s'));
			
			return $viewModel;
		}
	}
}