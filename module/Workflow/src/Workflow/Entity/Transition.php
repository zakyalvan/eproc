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
	public function getId() {
		return $id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="\Workflow\Entity\Workflow", fetch="lazy", inversedBy="transitions")
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
	public function getTriggerType() {
		return $this->triggerType;
	}
	public function setTriggerType($triggerType) {
		$this->triggerType = $triggerType;
	}
	
	/**
	 * @Orm\Column(name="TRANSITION_NAME", type="string", length="50", nullable=false)
	 */
	protected $name;
	public function getName() {
		return $name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @Orm\Column(name="TRANSITION_DESC", type="string", length="500", nullable=false)
	 */
	protected $description;
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\Arc", mappedBy="transition")
	 * 
	 * @var array
	 */
	protected $arcs;
	public function getArcs() {
		return $this->arcs;
	}
	public function setArcs($arcs) {
		$this->arcs = $arcs;
	}
	
	/**
	 * Transition handler untuk transition bersangkutan.
	 * 
	 * @Orm\Column(name="TRANSITION_HANDLER", type="string", length="100", nullable="false")
	 * 
	 * @var string
	 */
	protected $handler;
	public function getHandler() {
		return $this->handler;
	}
	public function setHandler($handler) {
		$this->handler = $handler;
	}
	
	/**
	 * Audit trails dari sebuah transisi untuk setiap instance/case.
	 * Dari sini bisa tau sebuah transisi pernah (minimal) dienable dalam instance mana saja.
	 * 
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\TransitionTrail", fetch="lazy", mappedBy="transition")
	 * 
	 * @var array
	 */
	protected $auditTrails;
	public function getAuditTrails() {
		return $this->auditTrails;
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
	 * @Orm\JoinColumn(name="PETUGAS_REKAM", type="string", referencedColumnName="KODE_USER", nullable=true)
	 */
	protected $createdBy;
	public function getCreatedBy() {
		return $this->createdBy;
	}
	
	/**
	 * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
	 */
	protected $updatedDate;
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_UBAH", type="string", referencedColumnName="KODE_USER", nullable=true)
	 */
	protected $updatedBy;
	public function getUpdatedBy() {
		return $this->updatedBy;
	}
}