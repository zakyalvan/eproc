<?php
namespace Workflow\Execution;

use Workflow\Entity\Instance;
use Workflow\Entity\Place;
use Workflow\Entity\Workflow;
use Workflow\Entity\Workitem;

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
	 * 
	 * @param Workflow $workflow
	 * @param unknown $datas
	 * 
	 * @return boolean
	 */
	public function hasActiveInstances(Workflow $workflow, $datas = array());
	
	/**
	 * Retrieve active instance (instance yang sedang berjalan) dengan berdasarkan workflow dan data yang diberikan.
	 * 
	 * @param Workflow $workflow
	 * @param unknown $datas
	 * @return array
	 */
	public function getActiveInstances(Workflow $workflow, $datas = array());
	
	/**
	 * Ambil workitem yang executable.
	 * 
	 * @param Instance $instance
	 * @param $workitemId
	 */
	public function getExecutableWorkitem(Instance $instance, $workitemId);
	
	/**
	 * Apakah workitem dapat dieksekusi dengan parameter yang diberikan.
	 * 
	 * @param Workitem $workitem
	 * @param array $datas
	 * @param unknown $userContext
	 * @param unknown $userRole
	 * @param unknown $userId
	 */
	public function canExecuteWorkitem(Workitem $workitem, array $datas, $userContext, $userRole, $userId);
	
	/**
	 * Eksekusi workitem, setelah itu route token pada palce sebelum trnsition dimana workitem ini berada.
	 * 
	 * @param Workitem $workitem
	 */
	public function executeWorkitem(Workitem $workitem, array $datas, $userContext, $userRole, $userId);
	
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