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
	 * @ORM\Column(name="TGL_REKAM", type="datetime", nullable=true)
	 */
	private $createdDate;
	public function getCreatedDate() {
		return $this->createdDate;
	}
	
	/**
	 * @ORM\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @ORM\JoinColumn(name="PETUGAS_REKAM", referencedColumnName="KODE_USER")
	 */
	private $createdBy;
	public function getCreatedBy() {
		return $this->createdBy;
	}
	
	/**
	 * @ORM\Column(name="TGL_UBAH")
	 */
	private $updatedDate;
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	
	/**
	 * @ORM\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @ORM\JoinColumn(name="PETUGAS_UBAH", referencedColumnName="KODE_USER")
	 */
	private $updatedBy;
	public function getUpdatedBy() {
		return $this->updatedBy;
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