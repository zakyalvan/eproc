<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;
use Application\Entity\Role;

/**
 * Table yang nyimpan data transisi.
 * 
 * @Orm\Entity(repositoryClass="Workflow\Entity\Repository\TransitionRepository")
 * @Orm\InheritanceType("SINGLE_TABLE")
 * @Orm\DiscriminatorColumn(name="TRANSITION_TRIGGER", type="string", length="255")
 * @Orm\DiscriminatorMap({"AUTO" = "Workflow\Entity\AutoTransition", "USER" = "Workflow\Entity\UserTransition", "TIME" = "Workflow\Entity\TimeTransition", "MESG" = "Workflow\Entity\MesgTransition, })
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
	 * @Orm\Column(name="TRANSITION_ID", type="integer", nullable=false)
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
	 * @Orm\Column(name="TRANSITION_TRIGGER", type="string", length="4", nullable=false)
	 */
	protected $triggerType;
	
	/**
	 * @Orm\Column(name="TRANSITION_NAME", type="string", length="50", nullable=false)
	 */
	protected $name;
	
	/**
	 * @Orm\Column(name="TRANSITION_DESC", type="string", length="500", nullable=false)
	 */
	protected $description;
	
	/**
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\Arc", mappedBy="transition")
	 * 
	 * @var array
	 */
	protected $arcs;
	
	/**
	 * Transition handler untuk transition bersangkutan.
	 * 
	 * @Orm\Column(name="TRANSITION_HANDLER", type="string", length="100", nullable="false")
	 * 
	 * @var string
	 */
	protected $handler;
	
	/**
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\TransitionTrail", fetch="lazy", mappedBy="transition")
	 * 
	 * @var array
	 */
	protected $auditTrails;
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
	 */
	protected $createdDate;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_REKAM", type="string", referencedColumnName="KODE_USER", nullable=true)
	 */
	protected $createdBy;
	
	/**
	 * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
	 */
	protected $updatedDate;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_UBAH", type="string", referencedColumnName="KODE_USER", nullable=true)
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
	public function setWorkflow(Workflow $workflow) {
		$this->workflow = $workflow;
	}
	
	public function getTriggerType() {
		return $this->triggerType;
	}
	public function setTriggerType($triggerType) {
		$this->triggerType = $triggerType;
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
	
	public function getHandler() {
		return $this->handler;
	}
	public function setHandler($handler) {
		$this->handler = $handler;
	}
	
	public function getAuditTrails() {
		return $this->auditTrails;
	}
	public function setAuditTrails($auditTrails) {
		$this->auditTrails = $auditTrails;
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