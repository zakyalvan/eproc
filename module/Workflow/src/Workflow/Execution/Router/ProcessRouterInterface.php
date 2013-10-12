<?php
namespace Workflow\Execution\Router;

use Workflow\Execution\Router\Exception\ProcessRouterException;
use Workflow\Entity\Token;

/**
 * Kontrak untuk process router.
 * 
 * @author zakyalvan
 */
interface ProcessRouterInterface {
	/**
	 * Route token ke next place.
	 * 
	 * @param Token $token
	 * @throws ProcessRouterException
	 */
	public function routeToNextPlaces(Token $token);
}
