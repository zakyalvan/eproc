<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoListProvider;
use Doctrine\ORM\QueryBuilder;

/**
 * Contract progress to list provider.
 * 
 * @author zakyalvan
 */
class ContractProgressTodoListProvider extends AbstractTodoListProvider {
	public function init() {
		
	}
	protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		return $queryBuilder;
	}
}