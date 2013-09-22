<?php
namespace Workflow\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Workflow\Service\DefinitionService;

/**
 * Base class untuk seluruh controller yang berusan tentang workflow definition.
 * 
 * @author zakyalvan
 */
abstract class DefinitionActionController extends AbstractActionController {
	/**
	 * Instance dari definition service.
	 * 
	 * @var DefinitionService
	 */
	protected $_definitionService;
	
	protected function _getDefinitionService() {
		// Crete instance definition service jika sebelumnya belum dibikin instance-nya.
		if($this->_definitionService == null) {
			$this->_definitionService = $this->serviceLocator->get("Workflow\Service\DefinitionService");
		}
		return $this->_definitionService;
	}
}