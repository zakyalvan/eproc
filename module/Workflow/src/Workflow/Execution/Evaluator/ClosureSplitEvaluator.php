<?php
namespace Workflow\Execution\Evaluator;

/**
 * Adapter jika split evaluator yang diberikan adalah closure (anonymous function).
 * 
 * @author zakyalvan
 */
class ClosureSplitEvaluator extends AbstractSplitEvaluator {
	/**
	 * @var \Closure
	 */
	private $closure;
	
	public function __construct(\Closure $closure) {
		parent::__construct();
		$this->closure = $closure;
	}

	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\AbstractSplitEvaluator::initialize()
	 */
	protected function initialize() {}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\AbstractSplitEvaluator::eveluate()
	 */
	public function eveluate() {
		return $this->closure($this->datas);
	}
}