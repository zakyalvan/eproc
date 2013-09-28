<?php
namespace Workflow\Execution\Assignment;

/**
 * Kontrak untuk assignment kontrok.
 * Assigment kontrol menentukan assignment workitem kepada user/kelompok user.
 * 
 * @author zakyalvan
 */
interface AssignmentRuleInterface {
	public function assign();
}