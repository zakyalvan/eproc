<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity audit trail dari enable dan eksekusi dari sebuah transition dalam instance tertentu.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_TRANSITION_TRAIL")
 * 
 * @author zakyalvan
 */
class TransitionTrail {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="TRAIL_ID", type="integer")
	 * 
	 * @var integer
	 */
	private $id;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Instance", fetch="lazy", inversedBy="auditTrails")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", type="string", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="TRANSITION_ID", type="integer", referencedColumnName="TRANSITION_ID")})
	 * 
	 * @var Transition
	 */
	private $transition;
	public function getTransition() {
		return $this->transition;
	}
	public function setTransition(Transition $transition) {
		$this->transition = $transition;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Instance", fetch="lazy")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", type="string", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="INSTANCE_ID", type="integer", referencedColumnName="INSTANCE_ID")})
	 * 
	 * @var Instance
	 */
	private $instance;
	public function getInstance() {
		return $this->instance;
	}
	public function setInstance(Instance $instance) {
		$this->instance = $instance;
	}
	
	/**
	 * @Orm\Column(name="ENABLED_TIME", type="datetime", nullable=false)
	 * 
	 * @var date
	 */
	private $enabledTime;
	public function getEnabledTime() {
		return $this->enabledTime;
	}
	public function setEnabledTime($enabledTime) {
		$this->enabledTime = $enabledTime;
	}
	
	/**
	 * @Orm\Column(name="EXECUTED_TIME", type="datetime", nullable=true)
	 * 
	 * @var date
	 */
	private $executedTime;
	public function getExucutedTime() {
		return $this->executedTime;
	}
	public function setExecutedTime($executedTime) {
		$this->executedTime = $executedTime;
	}
}