<?php
namespace Application\Todo;

use Zend\Paginator\Paginator;

/**
 * Base interface untuk todo list data provider.
 * 
 * @author zakyalvan
 */
interface TodoListProvider {
	/**
	 * Retrieve todo list.
	 * 
	 * @param unknown $page
	 * @param unknown $rows
	 * 
	 * @return Paginator
	 */
	public function getTodoList($page, $rowNums);
}