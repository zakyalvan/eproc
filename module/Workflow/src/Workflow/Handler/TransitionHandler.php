<?php
namespace Workflow\Handler;

/**
 * Kontrak untuk transition handler.
 * 
 * @author zakyalvan
 */
interface TransitionHandler {
	public function handle(Transition $transition);
}