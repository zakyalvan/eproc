<?php
namespace Workflow\Execution\Evaluator;

/**
 * Abstract kelas split evaluator.
 * 
 * @author zakyalvan
 * @see {@link SplitEvaluatorInterface}
 */
abstract class AbstractSplitEvaluator implements SplitEvaluatorInterface {
	protected $requiredDatas = array();
	protected $possibleOutput = array();
	protected $datas = array();
	
	public function __construct() {
		$this->initialize();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\SplitEvaluatorInterface::getPossibleOutput()
	 */
	public function getPossibleOutput() {
		return $this->possibleOutput;
	}

	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\SplitEvaluatorInterface::setDatas()
	 */
	public function setDatas(array $datas) {
		$className = __CLASS__;
		$requiredDataImplode = implode(", ", $this->requiredDatas);
		$providedDataImplode = implode(", ", array_keys($datas));
		
		// Evaluasi apakah data yang diberikan sesuai dengan kebutuhan evaluator.
		if(count($datas) < count($this->requiredDatas)) {
			throw new \InvalidArgumentException("Jumlah data yang diberikan untuk evaluator {$className} tidak sesuai dengan jumlah yang dibutuhkan. Required data key : '{$requiredDataImplode}' , provided data key '{$providedDataImplode}'", 999, null);
		}
		
		foreach ($this->requiredDatas as $requiredData) {
			if(!array_key_exists($requiredData, $datas)) {
				throw new \InvalidArgumentException("Content data yang diberikan tidak sesuai dengan kebutuhan evaluator {$className}. Required data key : '{$requiredDataImplode}' , provided data key '{$providedDataImplode}'", 1000, null);
			}
		}
		$this->datas = $datas;
	}
	
	/**
	 * Method ini yang perlu diimpelementasi dalam kelas konkrit split-evaluator.
	 * Sebenarnya cuma maksa developer untuk ingat untuk setup required-datas (Kalau hanya di konstruktor,takut lupa).
	 */
	protected function initialize();
	
	/**
	 * Method ini yang perlu diimpelementasi dalam kelas konkrit split-evaluator.
	 * 
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\SplitEvaluatorInterface::eveluate()
	 */
	public function eveluate();
}