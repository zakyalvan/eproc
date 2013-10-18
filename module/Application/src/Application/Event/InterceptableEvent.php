<?php
namespace Application\Event;

use Zend\EventManager\Event;

/**
 * Template event dimana listener dapat (memberikan flag) menghentikan aktifitas utama di proses yang mentrigger event.
 * 
 * @author zakyalvan
 */
class InterceptableEvent extends Event {
	protected $allowResume = true;
	public function setAllowResume($allowResume) {
		$this->setParam('allowResume', $allowResume);
		$this->stopPropagation(!$allowResume);
		$this->allowResume = $allowResume;
	}
	public function getAllowResume() {
		return $this->allowResume;
	}
	
	protected $message;
	public function setMessage($message) {
		$this->setParam('message', $message);
		$this->message = $message;
	}
	public function getMessage() {
		return $this->message;
	}
}