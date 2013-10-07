<?php
namespace Application\Todo;

use Application\Common\AbstractClassRegistry;
use Application\Todo\TodoListProviderInterface;

/**
 * Registry class todo list provider, implementasi dari {@link TodoListProviderInterface}
 * 
 * @author zakyalvan
 */
class TodoListProviderRegistry extends AbstractClassRegistry {
	public function __construct() {
		parent::__construct('Application\Todo\TodoListProviderInterface');
	}
	/**
	 * Sementara closure diabaikan.
	 * 
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractClassRegistry::handleClosure()
	 */
	protected function handleClosure(\Closure $closure) {
		
	}
}