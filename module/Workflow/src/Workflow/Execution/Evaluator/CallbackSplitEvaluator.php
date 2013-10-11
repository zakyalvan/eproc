<?php
namespace Workflow\Execution\Evaluator;

use Zend\Di\ServiceLocator;
/**
 * Adapter jika split evaluator yang diberikan adalah callback function atay closure (anonymous function).
 * 
 * @author zakyalvan
 */
class CallbackSplitEvaluator extends AbstractSplitEvaluator {
	/**
	 * @var function|\Closure
	 */
	private $callback;
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function __construct($callback, ServiceLocator $serviceLocator) {
		$this->callback = $callback;
		$this->serviceLocator = $serviceLocator;
	}

	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\AbstractSplitEvaluator::init()
	 */
	public function init() {}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\AbstractSplitEvaluator::eveluate()
	 */
	public function eveluate($datas = array()) {
		$this->setDatas($datas);
		return $this->callback($this->datas, $this->serviceLocator);
	}
}