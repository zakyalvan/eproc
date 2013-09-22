<?php
namespace Workflow\Entity\Transition;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_TRANSITION")
 * 
 * @author zakyalvan
 */
class Transition {
	/**
	 * @Orm\Id
	 * @Orm\GeneratedValue(strategy="AUTO")
	 * @Orm\Column(name="TRANSITION_ID", type="integer")
	 */
	protected $id;
	
	/**
	 * @Orm\ManyToOne(targetEntity="\Workflow\Entity\Workflow")
	 * @Orm\Column(name="WORKFLOW_ID", type="string")
	 */
	protected $workflow;
	
	/**
	 * @Orm\Column(name="TRANSITION_NAME", type="string")
	 */
	protected $name;
	
	/**
	 * @Orm\Column(name="TRANSITION_DESC", type="string")
	 */
	protected $description;
}