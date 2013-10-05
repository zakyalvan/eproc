<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoItem;

/**
 * Dto untuk item pekerjaan manajemen invoice kontrak.
 * 
 * @author zakyalvan
 */
class ContractInvoiceTodoItem extends AbstractTodoItem {
	public function __construct($context, $actionUrl, $createdDate) {
		parent::__construct($context, $actionUrl, $createdDate);
	}
	
	protected function formatActionUrl() {
		
	}
}