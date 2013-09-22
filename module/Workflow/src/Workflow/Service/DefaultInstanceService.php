<?php
namespace Workflow\Service;

use Zend\ServiceManager\ServiceManager;
use Workflow\Model\InstanceTable;
use Workflow\Model\TokenTable;
use Workflow\Model\WorkitemTable;
use Workflow\Model\Instance;

/**
 * Implementasi default dari {@link InstanceService}
 * 
 * @author zakyalvan
 */
class DefaultInstanceService implements InstanceService {
	/**
	 * Defininition service instance.
	 * 
	 * @var DefinitionService
	 */
	private $_definitionService;
	
	/**
	 * 
	 * @var InstanceTable
	 */
	private $_instanceTable;
	
	/**
	 * @var WorkitemTable
	 */
	private $_workitemTable;
	
	/**
	 * @var TokenTable
	 */
	private $_tokenTable;
	
	public function __construct(ServiceManager $serviceManager) {
		if($serviceManager == null) {
			$class = __CLASS__;
			throw new ServiceException("Parameter service manager harus diberikan untuk konstruktor {$class}");
		}

		$this->_definitionService = $serviceManager->get('Workflow\Service\DefinitionService');
		
		$this->_instanceTable = $serviceManager->get('Workflow\Model\InstanceTable');
		$this->_workitemTable = $serviceManager->get('Workflow\Model\WorkitemTable');
		$this->_tokenTable = $serviceManager->get('Workflow\Model\TokenTable');
	}
	
	public function startWorkflow($workflowId, $datas) {
		if(!$this->canStartWorkflow($workflowId)) {
			throw new ServiceException("Workflow tidak dapat distart");
		}
		
		$instance = new Instance();
		
		// Check apakah data yang diberikan sesuai dengan kebutuhan dari workflow definition.
		
		// Get start place untuk workflow bersangkutan.
		// Simpan data workflow instance.
		// Add token to start place.
		// Ambil data transition setelah start place (tentu saja ngambilnya melalui arc yang keluar dari start place).
		// Create workitem dari informasi transition dan instance.
		// Selesai, return instance.
	}

	public function canStartWorkflow($workflowId, $throwException = false) {
		return $this->_definitionService->isRegisteredWorkflow($workflowId);
	}
}