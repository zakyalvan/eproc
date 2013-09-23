<?php
namespace Workflow\Handler;

/**
 * Kontrak untuk transition handler.
 * 
 * @author zakyalvan
 */
interface TransitionHandler {
	/**
	 * Handle sebuah transition.
	 * 
	 * @param Transition $transition
	 */
	public function handle(Transition $transition);
}