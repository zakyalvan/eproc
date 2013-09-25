<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Instance;

/**
 * Custom token repository.
 * 
 * @author zakyalvan
 */
class TokenRepository extends EntityRepository {
	/**
	 * Apakah ada free token untuk instance dan pada place yang diberikan.
	 * 
	 * @param unknown $instance
	 * @param unknown $place
	 */
	public function hasFreeToken($instance, $place) {
		$instanceId = $instance;
		if($instance instanceof Instance) {
			$instanceId = $instance->getId();
		}
	}
	
	/**
	 * Create free token untuk instance dan pada place yang diberikan.
	 * 
	 * @param unknown $instance
	 * @param unknown $place
	 */
	public function createFreeToken($instance, $place) {
		
	}
}