<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;
use Application\Entity\User;

/**
 * @Orm\Entity
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
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Workflow", fetch="lazy")
	 * @Orm\JoinColumn(name="WORKFLOW_ID", type="string", referencedColumnName="WORKFLOW_ID")
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
	 * Instance referensi dari workitem.
	 * 
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Instance", fetch="lazy")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", type="string", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="INSTANCE_ID", type="integer", referencedColumnName="INSTANCE_ID")})
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
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Transition", fetch="lazy")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", type="string", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="TRANSITION_ID", type="integer", referencedColumnName="TRANSITION_ID")})
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
	 * @Orm\Column(name="WORKITEM_STATUS", type="string")
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
	 * @ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @JoinColumn(name="USER_ID", referencedColumnName="KODE_USER")
	 * 
	 * @var User
	 */
	protected $executor;
	public function getExecutor() {
		return $this->executor;
	}
	public function setExecutor(User $executor) {
		$this->executor = $executor;
	}
}