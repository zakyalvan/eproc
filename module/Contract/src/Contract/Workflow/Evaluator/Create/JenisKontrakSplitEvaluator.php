<?php
namespace Contract\Workflow\Evaluator\Create;

use Workflow\Execution\Evaluator\AbstractSplitEvaluator;
use Contract\Entity\Kontrak\Kontrak;

/**
 * Split evaluator untuk kenis kontrak.
 * 
 * @author zakyalvan
 */
class JenisKontrakSplitEvaluator extends AbstractSplitEvaluator {
	public function init() {
		// Inisiasi possible output.
		$this->possibleOutput[] = Kontrak::JENIS_PERJANJIAN;
		$this->possibleOutput[] = Kontrak::JENIS_SPK;
		
		// Inisiasi required attribute
		$this->requiredAttrubutes[] = 'JENIS_KONTRAK';
	}
	protected function doEvaluate() {
		return $this->datas['JENIS_KONTRAK'];
	}
}