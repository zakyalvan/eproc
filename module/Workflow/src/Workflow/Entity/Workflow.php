<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Entity yang menyimpan informasi untuk definisi workflow.
 * 
 * @ORM\Entity
 * @ORM\Table(name="EP_WF_WORKFLOW")
 */
class Workflow implements InputFilterAwareInterface {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="WORKFLOW_ID", type="string")
	 * @var string
	 */
	protected $id;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @ORM\Column(name="WORKFLOW_NAME", type="string", length="50", nullable=false)
	 * 
	 * @var string
	 */
	protected $name;
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @ORM\Column(name="WORKFLOW_DESC", type="string", length="500", nullable=true)
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
	 * @ORM\OneToMany(targetEntity="\Workflow\Entity\Place", mappedBy="workflow")
	 */
	protected $places;
	public function getPlaces() {
		return $this->places;
	}
	
	/**
	 * @ORM\OneToMany(targetEntity="\Workflow\Entity\Transition", mappedBy="workflow")
	 */
	protected $transitions;
	public function getTransitions() {
		return $this->transitions;
	}
	
	/**
	 * @ORM\OneToMany(targetEntity="Workflow\Entity\Instance", mappedBy="workflow")
	 * 
	 * @var array
	 */
	protected $instances;
	public function getInstances() {
		return $this->instances;
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

	
	public function __get($property) {
		return $this->{$property};
	}
	public function __set($property, $value) {
		$this->{$property} = $value;
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter) {
		
	}
	public function getInputFilter() {
		
	}
}