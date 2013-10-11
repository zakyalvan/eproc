<?php
namespace Workflow\Execution\Evaluator;

use Application\Common\AbstractClassRegistry;

/**
 * Registry yang nampung split evaluator.
 * 
 * @author zakyalvan
 */
class SplitEvaluatorRegistry extends AbstractClassRegistry {
	public function __construct() {
		parent::__construct('Workflow\Execution\Evaluator\SplitEvaluatorInterface', true);
	}
	
	protected function handleClosure($closure) {
		return $closure;
	}
}