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
	/**
	 * Konteks dari user eksekutor yang dapat mengeksekusi transisi ini.
	 * 
	 * @Orm\Column(name="USER_CONTEXT", type="string", length="255", nullable=true)
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
	 * Ini role yang harus mengeksekusi transisi ini
	 * (Jika transisi bertype user-triggered dan context == user, selain itu null).
	 *
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Role", fetch="lazy")
	 * @Orm\JoinColumn(name="ROLE_ID", type="string", referencedColumnName="KODE_FUNGSI")
	 *
	 * @var Role
	 */
	protected $role;
	
	
	/**
	 * Task yang harus dieksekusi jika instance dari transisi bersangkutan dihandle.
	 * (Jika transisi bertipe user-triggered).
	 *
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Task", fetch="lazy")
	 * @Orm\JoinColumn(name="TASK_ID", type="integer", referencedColumnName="TASK_ID")
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
	 * Nama dari kelas split evaluator jika transisi ini merupakan tempat eksplisit or-split.
	 * Dengan kata lain, jika atribut ini tidak diberikan dan jika ada split maka split tersebut
	 * adalah and-split.
	 * 
	 * @Orm\Column(name="SPLIT_EVALUATOR", type="string", length="255", nullable=true)
	 * 
	 * @var string
	 */
	protected $splitEvaluator;
	public function getSplitEvaluator() {
		return $this->splitEvaluator;
	}
	public function setSplitEvaluator($splitEvaluator) {
		$this->splitEvaluator = $splitEvaluator;
	}
}