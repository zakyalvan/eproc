<?php
namespace Contract\Todo;

use Zend\Authentication\AuthenticationService;
use Doctrine\ORM\QueryBuilder;
use Application\Todo\AbstractTodoListProvider;
use Application\Entity\Role;
use Doctrine\ORM\Query\Expr\Join;
use Procurement\Entity\Tender\TenderVendor;
use Procurement\Entity\Tender\VendorStatus;
use Application\Todo\Exception\RuntimeException;
use Doctrine\ORM\Query;

/**
 * To do list provider assign pengelola kontrak, setiap kali tender pengadaan baru selesai.
 * 
 * @author zakyalvan
 */
class ContractInitTodoListProvider extends AbstractTodoListProvider {
	const KODE_FUNGSI_CONTEXT_KEY = 'kodeRole';
	const KODE_KANTOR_CONTEXT_KEY = 'kodeKantor';
	const KODE_USER_CONTEXT_KEY = 'kodeUser';
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::init()
	 */
	public function init() {
		$this->searchableParams['kodeTender'] = array(
			'field' => 'tender.kode',
			'label' => 'Kode Tender'
		);
		
		$this->requiredContextDataKeys = array_merge($this->requiredContextDataKeys, array(self::KODE_FUNGSI_CONTEXT_KEY, self::KODE_KANTOR_CONTEXT_KEY));
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::buildQuery()
	 */
	protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		$kodeRole = $contextDatas[self::KODE_FUNGSI_CONTEXT_KEY];
		
		if($kodeRole == Role::KODE_APPROVAL_KONTRAK_DAN_VENDOR) {
			return $this->buildQueryApproverKontrak($queryBuilder, $contextDatas, $criterias);
		}
		else if($kodeRole == Role::KODE_PELAKSANA_KONTRAK) {
			return $this->buildQueryPengelolaKontrak($queryBuilder, $contextDatas, $criterias);
		}
	}
	
	/**
	 * Build query todo list untuk approver kontrak (Todo assign pengelola kontrak sebetulnya).
	 * 
	 * @param QueryBuilder $queryBuilder
	 * @param array $contextDatas
	 * @param array $criterias
	 */
	protected function buildQueryApproverKontrak(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		$queryBuilder->select(array('new Contract\Todo\ContractInitTodoItem(tender, kantor, tender.judulPekerjaan, tender.lingkupPekerjaan, vendor, vendor.nama, tender.tanggalSelesai)', 'tender'))
			->from('Procurement\Entity\Tender\Tender', 'tender')
			->innerJoin('tender.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->innerJoin('tender.listTenderVendor', 'listTenderVendor')
			->innerJoin('listTenderVendor.vendor', 'vendor')
			->innerJoin('listTenderVendor.vendorStatus', 'tenderVendorStatus', Join::WITH, $queryBuilder->expr()->eq('tenderVendorStatus.pemenang', ':pemenang'))
			->leftJoin('tender.listKontrak', 'listKontrak')
			->orderBy('tender.tanggalSelesai', 'DESC')
			->setParameter('pemenang', VendorStatus::FLAG_PEMENANG)
			->setParameter('kodeKantor', $contextDatas[self::KODE_KANTOR_CONTEXT_KEY]);
		//exit($queryBuilder->getQuery()->getSQL());
		//print_r($queryBuilder->getQuery()->getResult());
		//exit();
		return $queryBuilder;
	}
	
	/**
	 * Build query todo list untuk pengelola kontrak.
	 * 
	 * @param QueryBuilder $queryBuilder
	 * @param array $contextDatas
	 * @param array $criterias
	 */
	protected function buildQueryPengelolaKontrak(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		$queryBuilder->select('new Contract\Todo\ContractInitTodoItem()')
			->from('Procurement\Entity\Tender\Tender', 'tender')
			->innerJoin('tender.kantor', 'kantor', Join::WITH, $queryBuilder->expr()->eq('kantor.kode', ':kodeKantor'))
			->innerJoin('tender.listTenderVendor', 'listTenderVendor')
			->innerJoin('listTenderVendor.vendor', 'vendor')
			->innerJoin('listTenderVendor.vendorStatus', 'tenderVendorStatus', Join::WITH, $queryBuilder->expr()->eq('tenderVendorStatus.pemenang', ':pemenang'))
			->leftJoin('tender.listKontrak', 'listKontrak')
			->setParameter('pemenang', VendorStatus::FLAG_PEMENANG)
			->setParameter('kodeKantor', $contextDatas[self::KODE_KANTOR_CONTEXT_KEY])
			->where($queryBuilder->expr()->eq(
				$queryBuilder->expr()->count('listKontrak'), 
				0
			));
		return $queryBuilder;
	}
}