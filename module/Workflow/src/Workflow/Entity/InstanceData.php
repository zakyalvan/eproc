<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_INSTANCE_DATA")
 * 
 * @author zakyalvan
 */
class InstanceData {
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Instance", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="INSTANCE_ID", referencedColumnName="INSTANCE_ID")})
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
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\WorkflowAttribute", fetch="EAGER")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", type="string", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="WORKFLOW_ATTR_NAME", type="string", referencedColumnName="WORKFLOW_ATTR_NAME")})
	 * 
	 * @var WorkflowAttribute
	 */
	protected $attribute;
	public function getAttribute() {
		return $this->attribute;
	}
	public function setAttribute(WorkflowAttribute $attribute) {
		$this->attribute = $attribute;
	}
	
	/**
	 * @Orm\Colum(name="DATA_VALUE", type="string")
	 */
	protected $value;
	public function getValue() {
		return $this->value;
	}
	public function setValue($value) {
		$this->value = $value;
	}
}