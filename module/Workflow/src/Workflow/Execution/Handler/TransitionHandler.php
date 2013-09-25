<?php
namespace Workflow\Execution\Handler;

use Workflow\Entity\Instance;
use Workflow\Entity\Transition;
/**
 * Kontrak untuk transition handler.
 * 
 * @author zakyalvan
 */
interface TransitionHandler {
	/**
	 * Apakah handler dapat menghandle transisi yang diberikan.
	 * 
	 * @param Transition $transition
	 */
	public function canHandle(Transition $transition, Instance $instance);
	
	/**
	 * Handle sebuah transition.
	 * 
	 * @param Transition $transition
	 */
	public function handle(Transition $transition, Instance $instance);
}