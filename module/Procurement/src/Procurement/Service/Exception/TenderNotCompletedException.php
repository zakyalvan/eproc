<?php
namespace Procurement\Service\Exception;

class TenderNotCompletedException extends \RuntimeException {
	public function __construct($message) {
		parent::__construct($message, 100, null);
	}
}