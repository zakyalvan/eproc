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
	 * @param unknown $pageNumber
	 * @param unknown $itemCountPerPage
	 * @param unknown $additionalDatas
	 * @return Paginator
	 */
	public function getTodoList($pageNumber, $itemCountPerPage, $additionalDatas = array());
}