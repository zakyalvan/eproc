<?php
namespace Workflow\Execution\Handler;

use Workflow\Execution\Handler\Service\Exception\RegistryItemNotFoundException;
use Workflow\Execution\Handler\Service\Exception\RegistryItemAlreadyExistsException;
use Zend\Di\Exception\ClassNotFoundException;

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
	 * Paksa lebih awal kelas handler yang diberikan valid (implement TransitionHandler).
	 * 
	 * @param unknown $name
	 * @param unknown $handler
	 * @param string $overwrite
	 * @throws RegistryItemAlreadyExistsException
	 */
	public function add($name, $handler, $overwrite = false) {
		// Jika hanya diberikan nama handlernya, tanpa alias.
		if(is_integer($name)) {
			$name = $handler;
		}
		
		if(!$overwrite && $this->has($name)) {
			throw new RegistryItemAlreadyExistsException("Registry item dengan nama {$name} sudah ada dalam registry, pilih nama lain.", 101, null);
		}
		
		// Paksa dari awal handler yang dimasukan sesuai kebutuhan.
		if(!class_exists($handler, true)) {
			throw new \InvalidArgumentException("Kelas transition handler {$handler} tidak ditemukan, cek lagi namanya.", $code, $previous);
		}
		
		$interfaces = class_implements($handler);
		if(!array_key_exists('Workflow\Execution\Handler\TransitionHandler', $interfaces)) {
			throw new \InvalidArgumentException("Kelas transition handler yang diberikan bukan instance dari 'Workflow\Execution\Handler\TransitionHandler'", null, null);
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
	
	/**
	 * Ambil semua data handler, tapi copy-an saja, biar ga diapa-apain diluar.
	 * 
	 * @return multitype:
	 */
	public function getAll() {
		return array_merge(array(), $this->handlers);
	}
}