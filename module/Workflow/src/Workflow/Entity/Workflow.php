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