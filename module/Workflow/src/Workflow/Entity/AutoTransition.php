<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity yang mewakili transition yang ditrigger automatis (di-trigger setelah di-enable).
 * 
 * @Orm\Entity
 * 
 * @author zakyalvan
 */
class AutoTransition extends Transition {
	
}