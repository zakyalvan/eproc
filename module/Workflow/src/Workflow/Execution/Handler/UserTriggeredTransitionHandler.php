<?php
namespace Workflow\Execution\Handler;

use Workflow\Execution\Handler\Exception\InvalidHandlerParameterException;

/**
 * Handler untuk transisi dengan trigger jenis 'USER'.
 * Inti dari handler ini adalah membuat workitem baru untuk transition bersangkutan.
 * 
 * @author zakyalvan
 */
class UserTriggeredTransitionHandler implements TransitionHandler {
	/**
	 * Create Workitem untuk transisi bersangkutan.
	 * 
	 * @see \Workflow\Handler\TransitionHandler::handle()
	 */
	public function handle(Transition $transition) {
		if($transition == null) {
			throw new InvalidHandlerParameterException("Nilai parameter tidak boleh null.", 100, null);
		}
		
		if($transition instanceof UserTriggeredTransition) {
		
		}
	}
}