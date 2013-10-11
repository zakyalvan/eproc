<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity yang mewakili place dalam sebuah workflow.
 * 
 * @Orm\Entity(repositoryClass="Workflow\Entity\Repository\PlaceRepository")
 * @Orm\Table(name="EP_WF_PLACE")
 */
class Place {
	const TYPE_START_PLACE = 1;
	const TYPE_END_PLACE = 9;
	const TYPE_INTERMEDIATE_PLACE = 5;
	
	/**
	 * @Orm\Id
	 * @Orm\GeneratedValue(strategy="AUTO")
	 * @Orm\Column(name="PLACE_ID", type="integer")
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
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Workflow", fetch="lazy", inversedBy="places")
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
	 * Jenis dari place, apakah start place, end place atau intermediate place.
	 * Start place = 1, Intermediate place = 5 dan End place = 9
	 * 
	 * @Orm\Column(name="PLACE_TYPE", type="integer", nullable=false)
	 */
	protected $type;
	public function getType() {
		return $this->type;
	}
	public function setType($type) {
		$this->type = $type;
	}
	
	/**
	 * @Orm\Column(name="PLACE_NAME", type="string", length="50", nullable=false)
	 */
	protected $name;
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @Orm\Column(name="PLACE_DESC", type="string", length="500", nullable=true)
	 */
	protected $description;
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Workflow\Entity\Arc", mappedBy="place")
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