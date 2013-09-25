<?php
namespace Workflow\Execution\Evaluator;

/**
 * Registry yang nampung split evaluator.
 * 
 * @author zakyalvan
 */
class SplitEvaluatorRegistry {
	/**
	 * Ini isi registry.
	 * 
	 * @var unknown
	 */
	private $registry = array();
	
	/**
	 * Tambah evaluator ke registry. Pastikan bahwa kelas evaluator yang ditambahkan valid.
	 * 
	 * @param unknown $name
	 * @param unknown $evaluator
	 * @param string $overwrite
	 * @throws InvalidArgumentException
	 */
	public function add($name, $evaluator, $overwrite = false) {
		// Kalau diberikan array evaluator saja
		if(is_int($name)) {
			$name = $evaluator;
		}
		
		if($this->has($name) && !$overwrite) {
			throw new \InvalidArgumentException("Split evaluator dengan nama {$name} didefinisikan lebih dari sekali, silahkan cek lagi", 0, 0);
		}
		
		if(!class_exists($evaluator, true)) {
			throw new \InvalidArgumentException("Kelas split evaluator yang diberikan {$evaluator} tidak ditemuakan");
		}
		
		$interfaces = class_implements($evaluator);
		if(!array_key_exists('Workflow\Execution\Evaluator\SplitEvaluatorInterface', $interfaces)) {
			throw new \InvalidArgumentException("Kelas split evaluator {$evaluator} tidak mengimplement interface 'Workflow\Execution\Evaluator\SplitEvaluatorInterface'", 100, null);
		}
		
		$this->registry[$name] = $evaluator;
	}
	
	public function has($name) {
		return array_key_exists($name, $this->registry);
	}
	
	public function get($name) {
		if(!$this->has($name)) {
			throw new \InvalidArgumentException("Kelas split evalutor dengan yang diberikan '{$name}' tidak ditemukan dalam registry", $code, $previous);
		}
		return $this->registry[$name];
	}
	
	public function getAll() {
		return array_merge(array(), $this->registry);
	}
}