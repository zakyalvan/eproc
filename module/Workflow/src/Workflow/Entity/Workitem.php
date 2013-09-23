<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_WORKITEM")
 * 
 * @author zakyalvan
 */
class Workitem {
	protected $workflow;
	
}