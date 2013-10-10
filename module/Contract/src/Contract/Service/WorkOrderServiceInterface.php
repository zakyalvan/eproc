<?php
namespace Contract\Service;

use Contract\Entity\Kontrak\Kontrak;

/**
 * Kontrak untuk penanganan work order.
 * 
 * @author zakyalvan
 */
interface WorkOrderServiceInterface {
	public function canCreateWorkOrderForContract($kontrak);
	public function saveWorkOrder($workorder);
}