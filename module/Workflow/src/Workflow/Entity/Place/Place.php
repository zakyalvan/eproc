<?php
namespace Workflow\Entity\Place;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_PLACE")
 */
class Place {
	/**
	 * @Orm\Id
	 * @Orm\GeneratedValue(strategy="AUTO")
	 * @Orm\Column(name="PLACE_ID", type="integer")
	 */
	protected $id;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Workflow")
	 * @Orm\Column(name="WORKFLOW_ID", type="string")
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
}