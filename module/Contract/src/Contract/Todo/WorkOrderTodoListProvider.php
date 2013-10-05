<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoListProvider;
use Doctrine\ORM\QueryBuilder;

/**
 * Todo list workorder.
 * 
 * @author zakyalvan
 */
class WorkOrderTodoListProvider extends AbstractTodoListProvider {
	protected function initSearchableParameters($searchableParameters) {
		
	}
	protected function buildTodoListQuery(QueryBuilder $queryBuilder, $searchCriterias = array(), $additionalDatas = array()) {
		
	}
}