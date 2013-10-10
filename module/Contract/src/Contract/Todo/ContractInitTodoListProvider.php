<?php
namespace Contract\Todo;

use Zend\Authentication\AuthenticationService;
use Doctrine\ORM\QueryBuilder;
use Application\Todo\AbstractTodoListProvider;

/**
 * To do list provider assign pengelola kontrak, setiap kali tender pengadaan baru selesai.
 * 
 * @author zakyalvan
 */
class ContractInitTodoListProvider extends AbstractTodoListProvider {
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::init()
	 */
	public function init() {
		$this->searchableParams['kodeTender'] = array(
			'field' => 'tender.kode',
			'label' => 'Kode Tender'
		);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::buildQuery()
	 */
	protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		$kodeRole = null;
		if(isset($contextDatas['kodeRole'])) {
			$kodeFungsi = $contextDatas[$kodeRole];
		}
		else {
			/* @var $authenticationService AuthenticationService */
			$authenticationService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
			$authenticationService->getStorage();
			
			$kodeFungsi = null;
		}
		
		
		return $queryBuilder->getQuery();
	}
	
	/**
	 * Build query todo list untuk approver kontrak (Todo assign pengelola kontrak sebetulnya).
	 * 
	 * @param QueryBuilder $queryBuilder
	 * @param unknown $contextDatas
	 * @param unknown $criterias
	 */
	protected function buildQueryApproverKontrak(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		$queryBuilder->select('new Contract\Todo\ContractInitTodoItem()')
			->from('Procurement\Entity\Tender\Tender', 'tender')
			->innerJoin('tender.listTenderVendor', 'tenderVendor')
			->innerJoin('tenderVendor.vendor', 'vendor')
			->innerJoin('tenderVendor.vendorStatus', 'status', 'status.pemenang = :statusPemenang')
			->where('');
		return $queryBuilder;
	}
	
	/**
	 * Build query todo list untuk pengelola kontrak.
	 * 
	 * @param QueryBuilder $queryBuilder
	 * @param unknown $contextDatas
	 * @param unknown $criterias
	 */
	protected function buildQueryPengelolaKontrak(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		$queryBuilder->select('new Contract\Todo\ContractInitTodoItem()')
			->from('Procurement\Entity\Tender\Tender', 'tender')
			->innerJoin('tender.listTenderVendor', 'tenderVendor')
			->innerJoin('tenderVendor.vendor', 'vendor')
			->innerJoin('tenderVendor.vendorStatus', 'status', 'status.pemenang = :statusPemenang')
			->where('');
		return $queryBuilder;
	}
}