<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Table yang mewakili instance dari sebuah workflow (Workflow yang dieksekusi)
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_INSTANCE")
 * 
 * @author zakyalvan
 */
class Instance {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="INSTANCE_ID")
	 */
	protected $id;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Workflow")
	 * @Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID")
	 * 
	 * @var Workflow
	 */
	protected $workflow;
	
	/**
	 * @Orm\Column(name="INSTANCE_CONTEXT", type="string")
	 */
	protected $context;
	
	/**
	 * @Orm\Column(name="INSTANCE_STATUS", type="string")
	 */
	protected $status;
	
	/**
	 * Attribute tanggal start dari eksekusi instance workflow.
	 * 
	 * @Orm\Column(name="START_DATE")
	 */
	protected $startDate;
	
	/**
	 * Attribute tanggal berakhirnya eksekusi instance workflow.
	 * 
	 * @Orm\Column(name="END_DATE")
	 */
	protected $endDate;
	
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
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getWorkflow() {
		return $this->workflow;
	}
	public function setWorkflow(Workflow $workflow) {
		$this->workflow = $workflow;
	}
	
	public function getCreatedDate() {
		return $this->createdDate;
	}
	public function getCreatedBy() {
		return $this->createdBy;
	}
	
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	public function getContext() {
		return $this->context;
	}
	public function setContext($context) {
		$this->context = $context;
	}
	
	public function getStartDate() {
		return $this->startDate;
	}
	public function setStartDate($startDate) {
		$this->startDate = $startDate;
	}
	
	public function getEndDate() {
		return $this->endDate;
	}
	public function setEndDate($endDate) {
		$this->endDate = $endDate;
	}
	
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	public function getUpdatedBy() {
		return $this->updatedBy;
	}
}