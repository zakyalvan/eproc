<?php
namespace Workflow\Execution\Handler\Service;

use Workflow\Execution\Handler\Service\Exception\RegistryItemNotFoundException;
use Workflow\Execution\Handler\Service\Exception\RegistryItemAlreadyExistsException;
/**
 * Registry dari {@link TransitionHandler}.
 * Object dari kelas ini akan digunakan dalam kelas {@link TransitionHandlerAbstractFactory}
 * 
 * @author zakyalvan
 */
class TransitionHandlerRegistry {
	private $handlers = array();
	
	/**
	 * Add to registry.
	 * 
	 * @param unknown $name
	 * @param unknown $handler
	 * @param string $overwrite
	 * @throws RegistryItemAlreadyExistsException
	 */
	public function add($name, $handler, $overwrite = false) {
		if(!$overwrite && $this->has($name)) {
			throw new RegistryItemAlreadyExistsException("Registry item dengan nama {$name} sudah ada dalam registry, pilih nama lain.", 101, null);
		}
		$this->handlers[strtolower($name)] = $handler;
	}
	
	/**
	 * Apakah item dengan nama yang diberikan ada dalam registry.
	 * 
	 * @param unknown $name
	 * @return boolean
	 */
	public function has($name) {
		return array_key_exists(strtolower($name), $this->handlers);
	}
	
	/**
	 * Retrieve item dengan nama yang diberikan.
	 * 
	 * @param unknown $name
	 * @throws RegistryItemNotFoundException
	 * @return multitype:
	 */
	public function get($name) {
		if(!$this->has($name)) {
			throw new RegistryItemNotFoundException("Registry item dengan nama {$nama} tidak ditemukan", 100, null);
		}
		return $this->handlers[strtolower($name)];
	}
}