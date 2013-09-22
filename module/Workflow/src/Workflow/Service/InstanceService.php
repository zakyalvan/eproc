<?php
namespace Workflow\Service;

use Workflow\Model\Instance;

/**
 * Kontrak untuk instance manager.
 * 
 * @author zakyalvan
 */
interface InstanceService {
	/**
	 * Start new workflow. Pada intinya create instance baru lalu, buat token baru 
	 * pada start place untuk workflow yang bersangkutan. Sebelumnya parameter workflow harus divalidasi
	 * dulu, apakah workflow yang diberikan valid atau tidak.
	 * 
	 * @param unknown $workflowId
	 * @throws ServiceException
	 * @return Instance $instance
	 */
	function startWorkflow($workflowId, $datas);
	
	/**
	 * Apakah workflow id yang diberikan bisa distart atau tidak.
	 * 
	 * @param unknown $workflowId
	 */
	function canStartWorkflow($workflowId, $throwException = false);
}