<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Custom repository untuk arc.
 * 
 * @author zakyalvan
 */
class ArcRepository extends EntityRepository {
	public function getArcBetween($place, $transition, $direction) {
		
	}
	
	public function getInputArcFrom($place, $workflow) {
		
	}
}