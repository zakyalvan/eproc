<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoListProvider;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Workflow\Entity\Instance;
use Workflow\Entity\Workitem;
use Workflow\Entity\UserTransition;

/**
 * Todo list provider untuk proses manajemen kontrak.
 * 
 * @author zakyalvan
 */
class ContractCreateTodoListProvider extends AbstractTodoListProvider {
	const KODE_ROLE_CONTEXT_KEY = 'kodeRole';
	const KODE_KANTOR_CONTEXT_KEY = 'kodeKantor';
	const KODE_USER_CONTEXT_KEY = 'kodeUser';
	
	const PEMBUATAN_KONTRAK_WORKFLOW_ID = 'PEMBUATAN_KONTRAK';
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::init()
	 */
	public function init() {
		$this->requiredContextDataKeys = array(self::KODE_ROLE_CONTEXT_KEY, self::KODE_KANTOR_CONTEXT_KEY, self::KODE_USER_CONTEXT_KEY);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::buildQuery()
	 */
	protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		return $queryBuilder;
	}
}