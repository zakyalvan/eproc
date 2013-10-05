<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * File controller.
 * 
 * @author zakyalvan
 */
class FileController extends AbstractActionController {
	/**
	 * Download file.
	 */
	public function downloadAction() {
		$fileName = $this->params()->fromRoute('name', null);
		
		if($fileName) {
			
		}
	}
}