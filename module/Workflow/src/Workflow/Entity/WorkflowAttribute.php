<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Ini daftar dari workflow attribute.
 * Workflow attribute ini akan menjadi instance data (setelah dieksekusi).
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_WORKFLOW_ATTRIBUTE")
 * 
 * @author zakyalvan
 */
class WorkflowAttribute {
	const TYPE_INTEGER = "INTEGER";
	const TYPE_DOUBLE = "DOUBLE";
	const TYPE_DATE = "DATE";
	const TYPE_STRING = "STRING";
	const TYPE_BOOLEAN = "BOOLEAN";
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Workflow", fetch="LAZY")
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
	 * @Orm\Id
	 * @Orm\Column(name="WORKFLOW_ATTR_NAME", type="string")
	 */
	protected $name;
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @Orm\Column(name="WORKFLOW_ATTR_TYPE", type="string")
	 */
	protected $type;
	public function getType() {
		return $this->type;
	}
	public function setType($type) {
		$this->type = $type;
	}
}