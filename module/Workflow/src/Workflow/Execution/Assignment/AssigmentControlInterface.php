<?php
namespace Workflow\Execution\Assignment;

/**
 * Kontrak untuk assignment kontrol.
 * Assigment kontrol menentukan assignment workitem kepada user/kelompok user.
 * 
 * @author zakyalvan
 */
interface AssignmentControlInterface {
	public function assign();
}