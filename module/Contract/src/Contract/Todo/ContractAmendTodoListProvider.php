<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoListProvider;
use Doctrine\ORM\QueryBuilder;

/**
 * Perubahan kontrak todo list provider.
 * 
 * @author zakyalvan
 */
class ContractAmendTodoListProvider extends AbstractTodoListProvider {
	protected function initSearchableParameters($searchableParameters) {
	
	}
	protected function buildTodoListQuery(QueryBuilder $queryBuilder, $searchCriterias = array(), $additionalDatas = array()) {
	
	}
}