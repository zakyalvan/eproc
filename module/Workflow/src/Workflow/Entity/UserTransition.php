<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity yang mewakili transition yang harus ditrigger oleh user.
 * 
 * @Orm\Entity
 * 
 * @author zakyalvan
 */
class UserTransition extends Transition {
	const ASSIGNMENT_CONTROL_PUSH = 'PUSH';
	const ASSIGNMENT_CONTROL_PULL = 'PULL';
	
	/**
	 * Konteks dari user eksekutor yang dapat mengeksekusi transisi ini.
	 * 
	 * @Orm\Column(name="USER_CONTEXT", type="string", length=255, nullable=true)
	 * 
	 * @var string
	 */
	protected $userContext;
	public function getUserContext() {
		return $this->userContext;
	}
	public function setUserContext($userContext) {
		$this->userContext = $userContext;
	}
	
	/**
	 * Ini role yang harus mengeksekusi transisi ini.
	 * 
	 * @Orm\Column(name="USER_ROLE", type="string", nullable=true)
	 *
	 * @var string
	 */
	protected $userRole;
	public function getUserRole() {
		return $this->userRole;
	}
	public function setUserRole($userRole) {
		$this->userRole = $userRole;
	}
	
	/**
	 * Task yang harus dieksekusi jika instance dari transisi bersangkutan dihandle.
	 * (Jika transisi bertipe user-triggered).
	 *
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Task", fetch="LAZY")
	 * @Orm\JoinColumn(name="TASK_ID", referencedColumnName="TASK_ID")
	 *
	 * @var Task
	 */
	protected $task;
	public function getTask() {
		return $this->task;
	}
	public function setTask(Task $task) {
		$this->task = $task;
	}
	
	/**
	 * Assignment control, apakah item pekerjaan akan di push ke user atau di pull oleh user.
	 * 
	 * @Orm\Column(name="ASSIGNMENT_CONTROL", type="string", length=4, nullable=true)
	 * 
	 * @var string
	 */
	protected $assignmentControl;
	public function getAssignmentControl() {
		return $this->assignmentControl;
	}
	public function setAssignmentControl($assignmentControl) {
		$this->assignmentControl = $assignmentControl;
	}
	
	/**
	 * Penjelasan lanjutan dari field assignmentControl.
	 * 
	 * @Orm\Column(name="ASSIGNMENT_CRITERIA", type="string", length=100, nullable=true)
	 * 
	 * @var string
	 */
	protected $assignmentCriteria;
	public function getAssignmentCriteria() {
		return $this->assignmentCriteria;
	}
	public function setAssignmentCriteria($assignmentCriteria) {
		$this->assignmentCriteria = $assignmentCriteria;
	}
}