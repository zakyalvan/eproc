<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Trnsition yang ditrigger setelah beberapa waktu time limit tertentu.
 * 
 * @Orm\Entity
 * 
 * @author zakyalvan
 */
class TimeTransition extends Transition {
	/**
	 * Kapan deadline transition ini harus dieksekusi.
	 * Relatif terhadap enableddate.
	 * 
	 * @Orm\Column(name="TIME_LIMIT", type="integer", nullable=true)
	 * 
	 * @var integer
	 */
	protected $timeLimit;
	public function getTimeLimit() {
		return $this->timeLimit;
	}
	public function setTimeLimit($timeLimit) {
		$this->timeLimit = $timeLimit;
	}
}