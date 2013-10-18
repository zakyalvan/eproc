<?php
namespace Workflow\Execution\Event;

use Zend\EventManager\Event;
use Workflow\Entity\Workitem;

/**
 * Object event yang ditrigger pada saat sebuah workitem dieksekusi.
 * 
 * @author zakyalvan
 */
class WorkitemExecuteEvent extends Event {
	const PRE_EXECUTE = 'PRE_EXECUTE';
	const POST_EXECUTE = 'POST_EXECUTE';
	
	/**
	 * @var Workitem
	 */
	private $workitem;
	public function getWorkitem() {
		return $this->workitem;
	}
	public function setWorkitem(Workitem $workitem) {
		$this->workitem = $workitem;
	}
}