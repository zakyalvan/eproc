<?php
namespace Workflow\Execution\Event;

use Workflow\Entity\Workitem;
use Workflow\Entity\Workflow;
use Workflow\Entity\Transition;
use Workflow\Entity\Instance;

class WorkitemCreateEvent extends Event {
	const WORKITEM_PRE_ASSIGN = 'NEW_WORKITEM_PRE_ASSIGN';
	const WORKITEM_POST_ASSIGN = 'NEW_WORKITEM_POST_ASSIGN';
	
	/**
	 * Workflow tempat terjadinya
	 *
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
	 * Transition dimana workitem dibuat.
	 *
	 * @var Transition
	 */
	protected $transition;
	public function getTransition() {
		return $this->transition;
	}
	public function setTransition(Transition $transition) {
		$this->transition = $transition;
	}
	
	/**
	 * Instance dari workflow bersangkutan.
	 *
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
	 * Workitem yang baru dibikin.
	 *
	 * @var Workitem
	 */
	protected $workitem;
	public function getWorkitem() {
		return $this->workitem;
	}
	public function setWorkitem(Workitem $workitem) {
		$this->workitem = $workitem;
	}
	
	/**
	 * Instance dari workitem bersangkutan.
	 *
	 * @var array
	 */
	protected $instanceDatas;
	public function getInstanceDatas() {
		return $this->instanceDatas;
	}
	public function setInstanceDatas(array $instanceDatas) {
		$this->instanceDatas = $instanceDatas;
	}
}