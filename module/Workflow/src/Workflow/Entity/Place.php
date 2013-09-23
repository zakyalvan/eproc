<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
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
	
	/**
	 * Jenis dari place, apakah start place, end place atau intermediate place.
	 * Start place = 1, Intermediate place = 5 dan End place = 9
	 * 
	 * @Orm\Column(name="PLACE_TYPE", type="integer")
	 */
	protected $type;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Workflow")
	 * @Orm\JoinColumn(name="WORKFLOW_ID", type="string")
	 * 
	 * @var Workflow
	 */
	protected $workflow;
	
	/**
	 * @Orm\Column(name="PLACE_NAME", type="string")
	 */
	protected $name;
	
	/**
	 * @Orm\Column(name="PLACE_DESC", type="string")
	 */
	protected $description;
	
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
	private $updatedBy;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getType() {
		return $this->type;
	}
	public function setType($type) {
		$this->type = $type;
	}
	
	public function getWorkflow() {
		return $this->workflow;
	}
	public function setWorkflow(Workflow $workflow) {
		$this->workflow = $workflow;
	}
	
	public function getName() {
		return $this->name;
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