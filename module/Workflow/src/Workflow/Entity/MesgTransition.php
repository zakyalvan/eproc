<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity transition yang ditrigger berdasarkan message atau event yang diterima sistem.
 * 
 * @Orm\Entity
 * 
 * @author zakyalvan
 */
class MesgTransition extends Transition {
	
}