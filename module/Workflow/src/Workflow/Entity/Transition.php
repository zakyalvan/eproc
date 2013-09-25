<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;
use Application\Entity\Role;

/**
 * Table yang nyimpan data transisi.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_TRANSITION")
 * 
 * @author zakyalvan
 */
class Transition {
	const TRIGGER_BY_USER = "USER";
	const TRIGGER_BY_MESSAGE = "MESG";
	const TRIGGER_BY_AUTO = "AUTO";
	const TRIGGER_BY_TIME = "TIME";
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="TRANSITION_ID", type="integer")
	 */
	protected $id;
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="\Workflow\Entity\Workflow")
	 * @Orm\JoinColumn(name="WORKFLOW_ID", type="string", referencedColumnName="WORKFLOW_ID")
	 * 
	 * @var Workflow
	 */
	protected $workflow;
	
	/**
	 * Ini jenis trigger dari transition ini.
	 * USER jika transisi ini harus ditrigger uleh user.
	 * AUTO jika transisi ini ditrigger secara automatis.
	 * MESG jika transisi ini ditrigger setelah diterimanya message.
	 * TIME jika transisi ini ditrigger oleh waktu (contoh dalam percabangan implisit join).
	 * Perlu dicatat, untuk setiap transisi yang harus ditrigger oleh user maka sebelum
	 * 
	 * @Orm\Column(name="TRANSITION_TRIGGER", type="string")
	 */
	protected $triggerType;
	
	/**
	 * Context transisi (Misalnya Internal, External)
	 * Dipake jika transisi bertype user triggered.
	 * 
	 * @Orm\Column(name="TRANSITION_CONTEXT", type="string")
	 */
	protected $context;
	
	/**
	 * Ini role yang harus mengeksekusi transisi ini 
	 * (Jika transisi bertype user-triggered).
	 *
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Role", fetch="lazy")
	 * @Orm\JoinColumn(name="ROLE_ID", referencedColumnName="KODE_FUNGSI")
	 * 
	 * @var Role
	 */
	protected $role;
	
	/**
	 * Task yang harus dieksekusi jika instance dari transisi bersangkutan dihandle.
	 * (Jika transisi bertipe user-triggered).
	 * 
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Task", fetch="lazy")
	 * @Orm\JoinColumn(name="TASK_ID", referencedColumnName="TASK_ID")
	 * 
	 * @var Task
	 */
	protected $task;
	
	/**
	 * Attribute untuk transisi bertipe time-triggered.
	 * 
	 * @Orm\Column(name="TIME_LIMIT", type="integer")
	 */
	protected $timeLimit;
	
	/**
	 * @Orm\Column(name="TRANSITION_NAME", type="string")
	 */
	protected $name;
	
	/**
	 * @Orm\Column(name="TRANSITION_DESC", type="string")
	 */
	protected $description;
	
	/**
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\Arc", mappedBy="transition")
	 */
	protected $arcs;
	
	/**
	 * @Orm\Column(name="TGL_REKAM")
	 */
	protected $createdDate;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_REKAM", referencedColumnName="KODE_USER")
	 */
	protected $createdBy;
	
	/**
	 * @Orm\Column(name="TGL_UBAH")
	 */
	protected $updatedDate;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_UBAH", referencedColumnName="KODE_USER")
	 */
	protected $updatedBy;
	
	public function getId() {
		return $id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getWorkflow() {
		return $this->workflow;
	}
	public function setWorkflow($workflow) {
		$this->workflow = $workflow;
	}
	
	public function getTriggerType() {
		return $this->triggerType;
	}
	public function setTriggerType($triggerType) {
		$this->triggerType = $triggerType;
	}
	
	public function getRole() {
		return $this->role;
	}
	public function setRole(Role $role) {
		$this->role = $role;
	}
	
	public function getTask() {
		return $this->task;
	}
	public function setTask(Task $task) {
		$this->task = $task;
	}
	
	public function getTimeLimit() {
		return $this->timeLimit;
	}
	public function setTimeLimit($timeLImit) {
		$this->timeLimit = $timeLImit;
	}
	
	public function getName() {
		return $name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function getArcs() {
		return $this->arcs;
	}
	public function setArcs($arcs) {
		$this->arcs = $arcs;
	}
	
	public function getCreatedDate() {
		return $this->createdDate;
	}
	public function getCreatedBy() {
		return $this->createdBy;
	}
	
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	public function getUpdatedBy() {
		return $this->updatedBy;
	}
}