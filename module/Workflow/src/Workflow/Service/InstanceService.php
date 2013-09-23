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
	 * Apakah workflow id yang diberikan bisa distart atau tidak.
	 *
	 * @param unknown $workflowId
	 */
	public function canStartWorkflow($workflowId, $throwException = false);
	
	/**
	 * Start new workflow. Pada intinya create instance baru lalu, buat token baru 
	 * pada start place untuk workflow yang bersangkutan. Sebelumnya parameter workflow harus divalidasi
	 * dulu, apakah workflow yang diberikan valid atau tidak.
	 * 
	 * @param unknown $workflowId
	 * @throws ServiceException
	 * @return Instance $instance
	 */
	public function startWorkflow($workflowId, $datas);
}