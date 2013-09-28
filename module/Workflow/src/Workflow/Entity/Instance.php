<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Table yang mewakili instance dari sebuah workflow (Workflow yang dieksekusi)
 * 
 * @Orm\Entity(repositoryClass="Workflow\Entity\Repository\InstanceRepository")
 * @Orm\Table(name="EP_WF_INSTANCE")
 * 
 * @author zakyalvan
 */
class Instance {
	const STATUS_OPERATED = 'OP';
	const STATUS_FINISHED = 'FN';
	const STATUS_CANCELED = 'CN';
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="INSTANCE_ID", type="integer")
	 */
	protected $id;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Workflow", fetch="lazy", inversedBy="instances")
	 * @Orm\JoinColumn(name="WORKFLOW_ID", type="string", length="5", referencedColumnName="WORKFLOW_ID")
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
	 * @Orm\Column(name="INSTANCE_CONTEXT", type="string", nullable=false)
	 */
	protected $context;
	public function getContext() {
		return $this->context;
	}
	public function setContext($context) {
		$this->context = $context;
	}
	
	/**
	 * @Orm\Column(name="INSTANCE_STATUS", type="string", nullable=false)
	 */
	protected $status;
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\InstanceData", mappedBy="instance", fetch="lazy")
	 * 
	 * @var array
	 */
	protected $datas;
	public function getDatas() {
		return $this->datas;
	}
	public function setDatas(array $datas) {
		$this->datas = $datas;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\TransitionTrail", mappedBy="instance", fetch="lazy")
	 * 
	 * @var TransitionTrail
	 */
	protected $transitionTrails;
	public function getTransitionTrails() {
		return $this->transitionTrails;
	}
	public function setTransitionTrails($transitionTrails) {
		$this->transitionTrails = $transitionTrails;
	}
	
	/**
	 * Attribute tanggal start dari eksekusi instance workflow.
	 * 
	 * @Orm\Column(name="START_DATE", type="datetime", nullable=false)
	 */
	protected $startDate;
	public function getStartDate() {
		return $this->startDate;
	}
	public function setStartDate($startDate) {
		$this->startDate = $startDate;
	}
	
	/**
	 * Attribute tanggal berakhirnya eksekusi instance workflow.
	 * 
	 * @Orm\Column(name="FINISH_DATE", type="datetime", nullable=true)
	 * 
	 * @var date
	 */
	protected $finishDate;
	public function getFinishDate() {
		return $this->finishDate;
	}
	public function setFinishDate($finishDate) {
		$this->finishDate = $finishDate;
	}
	
	/**
	 * @Orm\Column(name="CANCEL_DATE", type="datetime", nullable=true)
	 * 
	 * @var date
	 */
	protected $cancelDate;
	public function getCancelDate() {
		return $this->cancelDate;
	}
	public function setCancelDate($cancelDate) {
		$this->cancelDate = $cancelDate;
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
	 */
	protected $createdDate;
	public function getCreatedDate() {
		return $this->createdDate;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_REKAM", referencedColumnName="KODE_USER", nullable=true)
	 */
	protected $createdBy;
	public function getCreatedBy() {
		return $this->createdBy;
	}
	
	/**
	 * @Orm\Column(name="TGL_UBAH")
	 */
	protected $updatedDate;
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_UBAH", referencedColumnName="KODE_USER")
	 */
	protected $updatedBy;
	public function getUpdatedBy() {
		return $this->updatedBy;
	}
}