<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Entity\Role;

/**
 * Table yang nyimpan data transisi.
 * 
 * @Orm\Entity(repositoryClass="Workflow\Entity\Repository\TransitionRepository")
 * @Orm\Table(name="EP_WF_TRANSITION")
 * @Orm\InheritanceType("SINGLE_TABLE")
 * @Orm\DiscriminatorColumn(name="TRANSITION_TRIGGER", type="string", length=255)
 * @Orm\DiscriminatorMap({"AUTO" = "Workflow\Entity\AutoTransition", "USER" = "Workflow\Entity\UserTransition", "TIME" = "Workflow\Entity\TimeTransition", "MESG" = "Workflow\Entity\MesgTransition"})
 * 
 * @author zakyalvan
 */
class Transition {
	/**
	 * Ini jenis trigger dari transition ini.
	 * USER jika transisi ini harus ditrigger uleh user.
	 * AUTO jika transisi ini ditrigger secara automatis.
	 * MESG jika transisi ini ditrigger setelah diterimanya message.
	 * TIME jika transisi ini ditrigger oleh waktu (contoh dalam percabangan implisit join).
	 * Perlu dicatat, untuk setiap transisi yang harus ditrigger oleh user maka sebelum
	 *
	 * @Orm\Column(name="TRANSITION_TRIGGER", type="string", length=4, nullable=false)
	 *
	 * @var string
	 */
	const TRIGGER_BY_USER = "USER";
	const TRIGGER_BY_MESSAGE = "MESG";
	const TRIGGER_BY_AUTO = "AUTO";
	const TRIGGER_BY_TIME = "TIME";
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="TRANSITION_ID", type="integer", nullable=false)
	 * @Orm\GeneratedValue(strategy="NONE")
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
	 * @Orm\ManyToOne(targetEntity="\Workflow\Entity\Workflow", fetch="LAZY", inversedBy="transitions")
	 * @Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID")
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
	 * @Orm\Column(name="TRANSITION_NAME", type="string", length=50, nullable=false)
	 */
	protected $name;
	public function getName() {
		return $name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @Orm\Column(name="TRANSITION_DESC", type="string", length=500, nullable=true)
	 * 
	 * @var string
	 */
	protected $description;
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\TransitionAttribute", fetch="LAZY", mappedBy="transition")
	 * 
	 * @var ArrayCollection
	 */
	protected $attributes;
	public function getAttributes() {
		return $this->attributes;
	}
	public function setAttributes($attributes) {
		$this->attributes = $attributes;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\Arc", fetch="LAZY", mappedBy="transition")
	 * 
	 * @var ArrayCollection
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
	 * Ini merupakan nama dari kelas transition handler untuk transisi bersangkutan.
	 * 
	 * @Orm\Column(name="TRANSITION_HANDLER", type="string", length=255, nullable=false)
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
	 * Nama kelas split evaluator jika arcs transition bersangkutan berjenis or-split (dan output arcs lebih dari satu).
	 * 
	 * @Orm\Column(name="SPLIT_EVALUATOR", type="string", length=255, nullable=true)
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
	
	/**
	 * Audit trails dari sebuah transisi untuk setiap instance/case.
	 * Dari sini bisa tau sebuah transisi pernah (minimal) dienable dalam instance mana saja.
	 * 
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\TransitionTrail", fetch="LAZY", mappedBy="transition")
	 * 
	 * @var ArrayCollection
	 */
	protected $auditTrails;
	public function getAuditTrails() {
		return $this->auditTrails;
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