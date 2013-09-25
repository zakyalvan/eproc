<?php
namespace Workflow\Execution;

use Workflow\Entity\Instance;
use Workflow\Entity\Place;

/**
 * Kontrak untuk instance manager (Eksekusi workflow).
 * 
 * @author zakyalvan
 */
interface ExecutionServiceInterface {
	/**
	 * Apakah workflow dapat distart atau tidak.
	 * 
	 * @param Workflow $workflow
	 * @return boolean
	 */
	public function canStartWorkflow(Workflow $workflow, array $datas);
	
	/**
	 * Start instance workflow baru.
	 * 
	 * @param Workflow $workflow
	 * @param array $datas
	 * @throws WorkflowManager
	 * @return Instance
	 */
	public function startWorkflow(Workflow $workflow, array $datas);
	
	/**
	 * Manage work item, didelegasiin ke object dari kelas {@link WorkitemManager}.
	 *
	 * @param Workitem $workitem
	 * @return WorkitemManager
	 */
	public function manageWorkitem(Workitem $workitem);
	
	/**
	 * Apakah instance sudah complete atau belum.
	 * 
	 * @param Instance $instance
	 */
	public function isCompletedInstance(Instance $instance);
	
	/**
	 * Retrieve di place mana saja token untuk instance yang bersangkutan nyangkut.
	 * 
	 * @return array Place
	 */
	public function getInstanceState(Instance $instance);
}