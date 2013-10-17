<?php
namespace Workflow\Execution\Evaluator;

use Zend\Stdlib\InitializableInterface;

/**
 * Abstract kelas split evaluator.
 * 
 * @author zakyalvan
 * @see {@link SplitEvaluatorInterface}
 */
abstract class AbstractSplitEvaluator implements SplitEvaluatorInterface, InitializableInterface {
	protected $requiredAttrubutes = array();
	protected $possibleOutput = array();
	protected $datas = array();
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\SplitEvaluatorInterface::getPossibleOutput()
	 */
	public function getPossibleOutput() {
		return $this->possibleOutput;
	}

	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\SplitEvaluatorInterface::getRequiredAttributes()
	 */
	public function getRequiredAttributes() {
		return $this->requiredAttrubutes;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\SplitEvaluatorInterface::setDatas()
	 */
	public function setDatas(array $datas) {
		$className = get_class($this);
		$requiredAttributesImplode = implode(', ', $this->requiredAttrubutes);
		$providedDatasImplode = implode(', ', array_keys($datas));
		
		// Evaluasi apakah data yang diberikan sesuai dengan kebutuhan evaluator.
		if(count($datas) < count($this->requiredAttrubutes)) {
			throw new \InvalidArgumentException(sprintf('Jumlah data yang diberikan untuk evaluator %s tidak sesuai dengan jumlah yang dibutuhkan. Required data key : %s, provided data key %s', $className, $requiredAttributesImplode, $providedDatasImplode), 999, null);
		}
		
		foreach ($this->requiredAttrubutes as $requiredAttribute) {
			if(!array_key_exists($requiredAttribute, $datas)) {
				throw new \InvalidArgumentException(sprintf('Content data yang diberikan tidak sesuai dengan kebutuhan evaluator %s. Required data key : %s, provided data key %s', $className, $requiredAttributesImplode, $providedDatasImplode), 1000, null);
			}
		}
		$this->datas = array_merge($this->datas, $datas);
	}
	
	/**
	 * Method ini yang perlu diimpelementasi dalam kelas konkrit split-evaluator.
	 * Sebenarnya cuma maksa developer untuk ingat untuk setup required-datas (Kalau hanya di konstruktor,takut lupa).
	 * Method ini otomatis dipanggil jika object split evaluator dicreate dalam service locator (misalnya dengan abstract-factory).
	 * 
	 * (non-PHPdoc)
	 * @see \Zend\Stdlib\InitializableInterface::init()
	 */
	abstract public function init();
	
	/**
	 * Method ini yang perlu diimpelementasi dalam kelas konkrit split-evaluator.
	 * 
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\Evaluator\SplitEvaluatorInterface::eveluate()
	 */
	public function eveluate($datas = array()) {
		$this->setDatas($datas);
		$evaluateResult = $this->doEvaluate();
		
		$validResult = false;
		foreach ($this->possibleOutput as $output) {
			if($output == $evaluateResult) {
				$validResult = true;
			}
		}
		
		if(!$validResult) {
			throw new \InvalidArgumentException(sprintf('Nilai balikan evaluasi %s bukan merupakan salah satu dari possible outputs %s', $evaluateResult, implode(', ', $this->possibleOutput)), 100, null);
		}
		return $validResult;
	}
	
	/**
	 * Method yang harus dispesifikasi dalam kelas turunan.
	 * 
	 * @return string
	 */
	abstract protected function doEvaluate();
}