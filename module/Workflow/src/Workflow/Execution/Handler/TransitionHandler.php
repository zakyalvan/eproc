<?php
namespace Workflow\Execution\Handler;

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
	public function canHandle(Transition $transition);
	
	/**
	 * Handle sebuah transition.
	 * 
	 * @param Transition $transition
	 */
	public function handle(Transition $transition);
}