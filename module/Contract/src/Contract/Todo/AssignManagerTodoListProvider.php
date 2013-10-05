<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoListProvider;
use Doctrine\ORM\QueryBuilder;

/**
 * To do list provider assign pengelola kontrak, setiap kali tender pengadaan baru selesai.
 * 
 * @author zakyalvan
 */
class AssignManagerTodoListProvider extends AbstractTodoListProvider {
	/**
	 * Init searchable parameters.
	 */
	protected function initSearchableParameters($searchableParameters) {
		$searchableParameter['kodeTender'] = array(
			'field' => 'tender.kode',
			'label' => 'Kode Tender'
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