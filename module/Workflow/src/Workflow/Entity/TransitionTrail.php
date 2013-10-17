<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity audit trail enable dan eksekusi dari sebuah transition dalam instance tertentu.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_TRANSITION_TRAIL")
 * 
 * @author zakyalvan
 */
class TransitionTrail {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="WORKFLOW_ID", type="string")
	 *
	 * @var string
	 */
	private $workflowId;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="INSTANCE_ID", type="string")
	 *
	 * @var string
	 */
	private $instanceId;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="TRANSITION_ID", type="integer")
	 *
	 * @var integer
	 */
	private $transitionId;
	
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
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Instance", fetch="LAZY", inversedBy="auditTrails")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="TRANSITION_ID", referencedColumnName="TRANSITION_ID")})
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
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Instance", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="INSTANCE_ID", referencedColumnName="INSTANCE_ID")})
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
	 * Kapan sebuah transisi dari sebuah instance workflow dienable.
	 * 
	 * @Orm\Column(name="ENABLED_TIME", type="datetime", nullable=false)
	 * 
	 * @var \DateTime
	 */
	private $enabledTime;
	public function getEnabledTime() {
		return $this->enabledTime;
	}
	public function setEnabledTime(\DateTime $enabledTime) {
		$this->enabledTime = $enabledTime;
	}
	
	/**
	 * @Orm\Column(name="EXECUTED_TIME", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	private $executedTime;
	public function getExucutedTime() {
		return $this->executedTime;
	}
	public function setExecutedTime(\DateTime $executedTime) {
		$this->executedTime = $executedTime;
	}
	
	/**
	 * Attribute canceled date, ini menentukan kapan sebuah transisi (yang sudah di-enable) tapi
	 * tidak jadi dieksekusi. Misalnya dalam kasus or-split implisit (as-late-as-possible) dimana salah satu 
	 * trnasisi ditrigger oleh waktu dan waktunya timeout.
	 * 
	 * @Orm\Column(name="CANCELED_TIME", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	private $canceledTime;
	public function getCanceledTime() {
		return $this->canceledTime;
	}
	public function setCanceledTime(\DateTime $canceledTime) {
		$this->canceledTime = $canceledTime;
	}
}