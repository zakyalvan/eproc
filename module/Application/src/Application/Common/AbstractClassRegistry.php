<?php
namespace Application\Common;

/**
 * Kelas untuk object class registry.
 * 
 * @author zakyalvan
 */
abstract class AbstractClassRegistry {
	protected $registry = array();
	protected $valueClass;
	protected $allowOverride = false;
	
	public function __construct($valueClass) {
		if(!class_exists($valueClass, true)) {
			throw new \InvalidArgumentException("Parameter value class yang diberikan tidak valid", 100, null);
		}
		$this->valueClass = $valueClass;
	}
	
	/**
	 * Tambahin item ke registry. Langsung chek validitas class yang diberikan.
	 * 
	 * @param unknown $name
	 * @param unknown $value
	 * @throws \InvalidArgumentException
	 */
	public function add($name, $value) {
		if($value instanceof \Closure) {
			$this->registry[$name] = $this->handleClosure($value);
		}
		else {
			if(!is_string($name)) {
				throw new \InvalidArgumentException(sprintf('Nama todo list provider harus diberikan dalam bentuk string.'), 99, null);
			}
			
			if(!class_exists($value, true)) {
				throw new \InvalidArgumentException(sprintf('Class %s yang diberikan tidak ditemukan', $value), 100, null);
			}
			
			$interfaces = class_implements($value, true);
			if(!array_key_exists($this->valueClass, $interfaces)) {
				throw new \InvalidArgumentException(sprintf('Class %s yang diberikan tidak mengimplementasi %s', $value, $this->valueClass), 101, null);
			}
			
			// Jika nama yang diberikan sudah ditemukan dalam registry dan override tidak diizinkan.
			if(array_key_exists($name, $this->registry) && !$this->allowOverride) {
				throw new \InvalidArgumentException(sprintf('Item class dengan nama %s sudah ada dalam registry, override tidak diizinkan', $name), 102, null);
			}
		
			$this->registry[$name] = $value;
		}
	}
	
	/**
	 * Bulk add.
	 * 
	 * @param unknown $items
	 */
	public function addAll($items = array()) {
		foreach ($items as $name => $value) {
			$this->add($name, $value);
		}
	}
	
	/**
	 * Apakah registry ada data dengan nama yang diberikan.
	 * 
	 * @param unknown $name
	 */
	public function has($name) {
		return array_key_exists($name, $this->registry);
	}
	/**
	 * Retrieve kelas dengan nama yang diberikan.
	 * 
	 * @param unknown $name
	 */
	public function get($name) {
		if(!$this->has($name)) {
			throw new \InvalidArgumentException('', 104, null);
		}
		
		return $this->registry[$name];
	}
	/**
	 * Set apakah override item diizinkan atau tidak.
	 * 
	 * @param unknown $allowOverride
	 */
	protected function setAllowOverride($allowOverride) {
		$this->allowOverride = $allowOverride;
	}
	
	/**
	 * Handle jika value yang diberikan adalah closure.
	 * 
	 * @param \Closure $closure
	 */
	abstract protected function handleClosure(\Closure $closure);
}