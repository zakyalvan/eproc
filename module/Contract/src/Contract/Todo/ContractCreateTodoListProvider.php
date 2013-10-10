<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoListProvider;
use Doctrine\ORM\QueryBuilder;

/**
 * Todo list provider untuk proses manajemen kontrak.
 * 
 * @author zakyalvan
 */
class ContractCreateTodoListProvider extends AbstractTodoListProvider {
	public function init() {
		$this->searchableParams['kodeTender'] = array(
			'field' => 'tender.kode',
			'label' => 'Kode Tender'
		);
		$this->searchableParams['kodeKontrak'] = array(
			'field' => 'kontrak.kode',
			'label' => 'Kode Kontrak'
		);
	}
	
	protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		
	}
}