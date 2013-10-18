<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;
use Application\Entity\User;

/**
 * @Orm\Entity(repositoryClass="Workflow\Entity\Repository\WorkitemRepository")
 * @Orm\Table(name="EP_WF_WORKITEM")
 * 
 * @author zakyalvan
 */
class Workitem {
	const STATUS_ENABLED = 'EN';
	const STATUS_CANCELED = 'CN';
	const STATUS_FINISHED = 'FN';
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="WORKFLOW_ID", type="string")
	 * 
	 * @var string
	 */
	private $workflowId;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="INSTANCE_ID", type="integer")
	 * 
	 * @var integer
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
	 * @Orm\Column(name="WORKITEM_ID", type="integer")
	 */
	private $id;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * Instance referensi dari workitem.
	 * 
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Instance", fetch="LAZY", inversedBy="workitems")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="INSTANCE_ID", referencedColumnName="INSTANCE_ID")})
	 * 
	 * @var Instance
	 */
	protected $instance;
	public function getInstance() {
		return $this->instance;
	}
	public function setInstance(Instance $instance) {
		$this->workflowId = $instance->getWorkflow()->getId();
		$this->instanceId = $instance->getId();
		$this->instance = $instance;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\UserTransition", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="TRANSITION_ID", referencedColumnName="TRANSITION_ID")})
	 * 
	 * @var UserTransition
	 */
	protected $transition;
	public function getTransition() {
		return $this->transition;
	}
	public function setTransition(Transition $transition) {
		$this->transitionId = $transition->getId();
		$this->transition = $transition;
	}
	
	/**
	 * @Orm\Column(name="WORKITEM_STATUS", length=2, type="string")
	 */
	protected $status;
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * @Orm\Column(name="ENABLED_DATE", type="datetime", nullable=false)
	 */
	protected $enabledDate;
	public function getEnabledDate() {
		return $this->enabledDate;
	}
	public function setEnabledDate($enabledDate) {
		$this->enabledDate = $enabledDate;
	}
	
	/**
	 * @Orm\Column(name="CANCELED_DATE", type="datetime", nullable=true)
	 */
	protected $cancledDate;
	public function getCanceledDate() {
		return $this->cancledDate;
	}
	public function setCanceledDate($canceledDate) {
		$this->cancledDate = $canceledDate;
	}
	
	/**
	 * @Orm\Column(name="FINISHED_DATE", type="datetime", nullable=true)
	 */
	protected $finishedDate;
	public function getFinishedDate() {
		return $this->finishedDate;
	}
	public function setFinishedDate($finishedDate) {
		$this->finishedDate = $finishedDate;
	}
	
	/**
	 * @Orm\Column(name="WORKITEM_CONTEXT", type="string", nullable=false)
	 */
	protected $context;
	public function getContext() {
		return $this->context;
	}
	public function setContext($context) {
		$this->context = $context;
	}
	
	/**
	 * Eksekutor workitem.
	 * 
	 * @Orm\Column(name="USER_ID", type="string", nullable=true)
	 * 
	 * @var string
	 */
	protected $executor;
	public function getExecutor() {
		return $this->executor;
	}
	public function setUserExecutor($executor) {
		$this->executor = $executor;
	}
}