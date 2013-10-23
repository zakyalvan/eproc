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
	const KODE_KANTOR_CONTEXT_KEY = 'kodeKantor';
	const KODE_USER_CONTEXT_KEY = 'kodeUser';
	const KODE_FUNGSI_CONTEXT_KEY = 'kodeFungsi';
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::init()
	 */
	public function init() {
		$this->requiredContextDataKeys = array(
			
		);
	}
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::buildQuery()
	 */
	protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		
		return $queryBuilder;
	}
}