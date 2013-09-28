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
	protected $id;
	
	/**
	 * Kapan deadline transition ini harus dieksekusi.
	 * 
	 * @Orm\Column(name="TIME_LIMIT", type="datetime", nullable=true)
	 * 
	 * @var date
	 */
	private $timeLimit;
	public function getTimeLimit() {
		return $this->timeLimit;
	}
	public function setTimeLimit($timeLimit) {
		$this->timeLimit = $timeLimit;
	}
}