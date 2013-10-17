<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entitas yang menunjukan attribut-atribut yang diperlukan pada saat mentrigger sebuah transisi.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_TRANSITION_ATTR")
 * 
 * @author zakyalvan
 */
class TransitionAttribute {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="WORKFLOW_ID", type="string")
	 * 
	 * @var string
	 */
	private $workflowId;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="TRANSITION_ID", type="integer")
	 *
	 * @var integer
	 */
	private $transitionId;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="WORKFLOW_ATTR_NAME", type="string")
	 *
	 * @var string
	 */
	private $workflowAttributeName;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Transition", fetch="LAZY")
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
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\WorkflowAttribute", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="WORKFLOW_ATTR_NAME", referencedColumnName="WORKFLOW_ATTR_NAME")})
	 * 
	 * @var WorkflowAttribute
	 */
	private $workflowAttribute;
	public function getWorkflowAttribute() {
		return $this->workflowAttribute;
	}
	public function setWorkflowAttribute(WorkflowAttribute $workflowAttribute) {
		$this->workflowAttribute = $workflowAttribute;
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	protected $createdDate;
	public function getCreatedDate() {
		return $this->createdDate;
	}
	public function setCreatedDate(\DateTime $createdDate) {
		$this->createdDate = $createdDate;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_REKAM", type="string", nullable=true)
	 * 
	 * @var string
	 */
	protected $createdBy;
	public function getCreatedBy() {
		return $this->createdBy;
	}
	public function setCreatedBy($createdBy) {
		$this->createdBy = $createdBy;
	}
	
	/**
	 * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	protected $updatedDate;
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	public function setUpdatedDate(\DateTime $updateDate) {
		$this->updatedDate = $updateDate;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_UBAH", type="string", nullable=true)
	 * 
	 * @var string
	 */
	protected $updatedBy;
	public function getUpdatedBy() {
		return $this->updatedBy;
	}
	public function setUpdatedBy($updatedBy) {
		$this->updatedBy = $updatedBy;
	}
}