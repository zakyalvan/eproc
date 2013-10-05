<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoListProvider;
use Doctrine\ORM\QueryBuilder;

/**
 * Provider untuk list pekerjaan manajemen ivoice/tagihan.
 * 
 * @author zakyalvan
 */
class ContractInvoiceTodoListProvider extends AbstractTodoListProvider {
	protected function initSearchableParameters($searchableParameters) {
		
	}
	protected function buildTodoListQuery(QueryBuilder $queryBuilder) {
		
	}
}