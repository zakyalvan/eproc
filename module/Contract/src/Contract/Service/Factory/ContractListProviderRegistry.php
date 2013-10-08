<?php
namespace Contract\Service\Factory;

use Application\Common\AbstractClassRegistry;

/**
 * 
 * @author zakyalvan
 */
class ContractListProviderRegistry extends AbstractClassRegistry {
	public function __construct() {
		parent::__construct('Contract\Service\ContractListProviderInterface', true);
	}
	
	protected function handleClosure(\Closure $closure) {}
}