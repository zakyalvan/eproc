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
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var string
	 */
	protected $id;
	
	/**
	 * @ORM\Column(name="WORKFLOW_NAME", type="string")
	 * @var string
	 */
	protected $name;
	
	/**
	 * @ORM\Column(name="WORKFLOW_DESC", type="string")
	 * @var string
	 */
	protected $description;
	
	/**
	 * @ORM\OneToMany(targetEntity="\Workflow\Entity\Place", mappedBy="workflow")
	 */
	protected $places;
	
	/**
	 * @ORM\OneToMany(targetEntity="\Workflow\Entity\Transition", mappedBy="workflow")
	 */
	protected $transitions;
	
	/**
	 * @Orm\Column(name="TGL_REKAM")
	 */
	private $createdDate;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_REKAM", referencedColumnName="KODE_USER")
	 */
	private $createdBy;
	
	/**
	 * @Orm\Column(name="TGL_UBAH")
	 */
	private $updatedDate;
	
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
	
	public function getPlaces() {
		return $this->places;
	}
	public function setPlaces($places) {
		$this->places = $places;
	}
	
	public function getTransitions() {
		return $this->transitions;
	}
	public function setTransitions($transitions) {
		$this->transitions = $transitions;
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