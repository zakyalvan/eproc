<?php
namespace Workflow\Execution\Event;

use Zend\EventManager\Event;
use Workflow\Entity\Workflow;
use Workflow\Entity\Instance;
use Application\Event\InterceptableEvent;

/**
 * Event yang dipublish pada saat sebuah workflow distart (Atau dengan kata lain instance workflow dibuat).
 * 
 * @author zakyalvan
 */
class WorkflowStartEvent extends InterceptableEvent {
	const WORKFLOW_PRE_START = 'WORKFLOW_PRE_START';
	const WORKFLOW_POST_START = 'WORKFLOW_POST_START';
	
	/**
	 * @var Workflow
	 */
	protected $workflow;
	public function getWorkflow() {
		return $this->workflow;
	}
	public function setWorkflow(Workflow $workflow) {
		$this->workflow = $workflow;
	}
	
	/**
	 * @var Instance
	 */
	protected $instance;
	public function getInstance() {
		return $this->instance;
	}
	public function setInstance(Instance $instance) {
		$this->instance = $instance;
	}
	
	/**
	 * @var array
	 */
	protected $startDatas;
	public function getStartDatas() {
		return array_merge(array(), $this->startDatas);
	}
	public function setStartDatas(array $startDatas) {
		$this->startDatas = $startDatas;
	}
}