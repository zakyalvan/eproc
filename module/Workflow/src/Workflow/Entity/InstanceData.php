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
	 * @Orm\Column(name="WORKFLFOW_ID", type="string")
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
	 * @Orm\Column(name="WORKFLOW_ATTR_NAME", type="string")
	 *
	 * @var string
	 */
	private $workflowAttributeName;
	
	/**
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
		$this->instanceId = $instance->getId();
		$this->workflowId = $instance->getWorkflow()->getId();
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\WorkflowAttribute", fetch="EAGER")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="WORKFLOW_ATTR_NAME", referencedColumnName="WORKFLOW_ATTR_NAME")})
	 * 
	 * @var WorkflowAttribute
	 */
	protected $attribute;
	public function getAttribute() {
		return $this->attribute;
	}
	public function setAttribute(WorkflowAttribute $attribute) {
		$this->attribute = $attribute;
		$this->workflowAttributeName = $attribute->getName();
		if($this->workflowId != null && $attribute->getWorkflow() != null && $this->workflowId != $attribute->getWorkflow()->getId()) {
			throw new \InvalidArgumentException('Parameter workflow attribute tidak valid.', 100, null);
		}
	}
	
	/**
	 * @Orm\Column(name="DATA_VALUE", type="string")
	 */
	protected $value;
	public function getValue() {
		return $this->value;
	}
	public function setValue($value) {
		$this->value = $value;
	}
}