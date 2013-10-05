<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoListProvider;
use Doctrine\ORM\QueryBuilder;

/**
 * Todo list provider untuk proses manajemen kontrak.
 * 
 * @author zakyalvan
 */
class ContractManagementTodoListProvider extends AbstractTodoListProvider {
	/**
	 * Init searchable parameters.
	 */
	protected function initSearchableParameters($searchableParameters) {
		$searchableParameter['kodeTender'] = array(
			'field' => 'tender.kode',
			'label' => 'Kode Tender'
		);
		$searchableParameter['kodeKontrak'] = array(
			'field' => 'kontrak.kode',
			'label' => 'Kode Kontrak'
		);
	}
	/**
	 * (non-PHPdoc)
	 * @see \Application\Todo\AbstractTodoListProvider::buildTodoListQuery()
	 */
	protected function buildTodoListQuery(QueryBuilder $queryBuilder, $searchCriterias = array(), $additionalDatas = array()) {
		
		return $queryBuilder->getQuery();
	}
}