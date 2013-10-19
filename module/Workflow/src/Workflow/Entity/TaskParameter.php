<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_TASK_PARAM")
 * 
 * @author zakyalvan
 */
class TaskParameter {
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Task", fetch="LAZY", inversedBy="parameters")
	 * @Orm\JoinColumn(name="TASK_ID", referencedColumnName="TASK_ID")
	 * 
	 * @var Task
	 */
	private $task;
	public function getTask() {
		return $this->task;
	}
	public function setTask(Task $task) {
		$this->task = $task;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="TASK_PARAM_NAME", type="string")
	 *
	 * @var string
	 */
	private $name;
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @Orm\Column(name="TASK_PARAM_VALUE")
	 * 
	 * @var unknown
	 */
	private $value;
	public function getValue() {
		return $this->value;
	}
	public function setValue($value) {
		$this->value = $value;
	}
}