<?php
namespace Contract\Service;

use Contract\Entity\Kontrak\Kontrak;

/**
 * Kontrak untuk penanganan work order.
 * 
 * @author zakyalvan
 */
interface WorkOrderServiceInterface {
	/**
	 * Apakah dapat membuat workorder untuk kontrak yang diberikan.
	 * 
	 * @param Kontrak|string $kontrak
	 */
	public function canCreateWorkOrder($kontrak);
	
	/**
	 * Simpan data workorder.
	 * 
	 * @param unknown $workorder
	 */
	public function saveWorkOrder($workorder);
}