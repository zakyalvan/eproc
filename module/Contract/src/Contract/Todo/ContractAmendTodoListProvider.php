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
	const KODE_KANTOR_CONTEXT_KEY = 'kodeKantor';
	const KODE_KONTRAK_CONTEXT_KEY = 'kodeKontrak';
	const KODE_ROLE_CONTEXT_KEY = 'kodeRole';
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::init()
	 */
	public function init() {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::buildQuery()
	 */
	protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		
	}
}