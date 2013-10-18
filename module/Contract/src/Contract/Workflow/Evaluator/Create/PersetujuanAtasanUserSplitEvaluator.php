<?php
namespace Contract\Workflow\Evaluator\Create;

use Workflow\Execution\Evaluator\AbstractSplitEvaluator;

/**
 * 
 * @author zakyalvan
 */
class PersetujuanAtasanUserSplitEvaluator extends AbstractSplitEvaluator {
	public function init() {
		$this->possibleOutput[] = 'DISETUJUI';
		$this->possibleOutput[] = 'TIDAK_DISETUJUI';
		
		$this->requiredAttrubutes[] = 'APPROVAL_ATASAN_USER';
	}
	protected function doEvaluate() {
		if($this->datas['APPROVAL_ATASAN_USER']) {
			return 'DISETUJUI';
		}
		return 'TIDAK_DISETUJUI';
	}
}