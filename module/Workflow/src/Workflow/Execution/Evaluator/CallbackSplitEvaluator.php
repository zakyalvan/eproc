<?php
namespace Workflow\Execution\Evaluator;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

/**
 * Adapter jika split evaluator yang diberikan adalah callback function atay closure (anonymous function).
 * 
 * @author zakyalvan
 */
class CallbackSplitEvaluator extends AbstractSplitEvaluator implements ServiceLocatorAware {
	/**
	 * @var function|\Closure
	 */
	private $callback;
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function __construct($callback) {
		$this->callback = $callback;
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
	protected function doEveluate() {
		return $this->callback($this->datas, $this->serviceLocator);
	}
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
	 */
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}