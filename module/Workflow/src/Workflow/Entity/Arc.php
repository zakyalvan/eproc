<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;
use Workflow\Entity\Workflow;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_ARC")
 * 
 * @author zakyalvan
 */
class Arc {
	/**
	 * Konstanta type dari input arc (arc keluar dari place dan masuk ke transition).
	 */
	const ARC_DIRECTION_INPUT = 1;
	
	/**
	 * Konstanta type dari output arc (arc keluar dari transition dan masuk ke place).
	 */
	const ARC_DIRECTION_OUTPUT = 2;
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Place", fetch="LAZY", inversedBy="arcs")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", type="string", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="PLACE_ID", type="integer", referencedColumnName="PLACE_ID")})
	 * 
	 * @var Place
	 */
	private $place;
	public function getPlace() {
		return $this->place;
	}
	public function setPlace(Place $place) {
		$this->place = $place;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Transition", fetch="LAZY", inversedBy="arcs")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", type="string", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="TRANSITION_ID", type="integer", referencedColumnName="TRANSITION_ID")})
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
	 * @Orm\Id
	 * @Orm\Column(name="DIRECTION", type="integer", nullable="false")
	 */
	private $direction;
	public function getDirection() {
		return $this->direction;
	}
	public function setDirection($direction) {
		$this->direction = $direction;
	}
	
	/**
	 * @Orm\Column(name="ARC_TYPE", type="string", length="50", nullable=true)
	 * 
	 * @var string
	 */
	private $type;
	public function getType() {
		return $this->type;
	}
	public function setType($type) {
		$this->type = $type;
	}
	
	/**
	 * Label adalah pembantu jika kondisional transition harus dipilih, workitem handler harus return label arc ini
	 * lalu flow berikutnya mengikuti label ini.
	 * Label arc ini harus unik dalam scope sebuah proses workflow. 
	 * 
	 * @Orm\Column(name="ARC_LABEL", type="string", length="50", nullable=false)
	 */
	private $label;
	public function getLabel() {
		return $this->label;
	}
	public function setLabel($label) {
		$this->label = $label;
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM")
	 */
	private $createdDate;
	public function getCreatedDate() {
		return $this->createdDate;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_REKAM", referencedColumnName="KODE_USER")
	 */
	private $createdBy;
	public function getCreatedBy() {
		return $this->createdBy;
	}
	
	/**
	 * @Orm\Column(name="TGL_UBAH")
	 */
	private $updatedDate;
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_UBAH", referencedColumnName="KODE_USER")
	 */
	private $updatedBy;	
	public function getUpdatedBy() {
		return $this->updatedBy;
	}
}