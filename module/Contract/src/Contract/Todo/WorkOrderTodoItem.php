<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoItem;

/**
 * Dto object untuk item pekerjaan workorder.
 * 
 * @author zakyalvan
 */
class WorkOrderTodoItem extends AbstractTodoItem {
	public function __construct($context, $actionUrl, $createdDate) {
		parent::__construct($context, $actionUrl, $createdDate);
	}
	
	protected function formatActionUrl() {
		return '#';
	}
}