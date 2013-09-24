<?php
namespace Workflow\Execution\Evaluator;

/**
 * Ini base interface untuk evaluator dalam percabangan/split yang memerlukan 
 * (or split terjadi setelah transisi dieksekusi).
 * Evalusi menggunakan attribute dari workflow atau lebih tepatnya instance datas.
 * 
 * @author zakyalvan
 */
interface SplitEvaluatorInterface {
	/**
	 * Return array dari possible output dari split evaluator. Ini untuk keperluan validasi spliting
	 * dan workflow secara keseluruhan.
	 *
	 * @return array
	 */
	public function getPossibleOutput();
	
	/**
	 * Evaluasi apakah kondisi percabangan (fork) ke cabang atau arc yang mana.
	 * 
	 * @param array $datas
	 * @return string nama dari arc.
	 */
	public function eveluate(array $datas);
}