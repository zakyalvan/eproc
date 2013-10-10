<?php
namespace Contract\Service;

use Doctrine\ORM\QueryBuilder;
use Contract\Entity\Kontrak\Kontrak;
use Zend\ModuleManager\Feature\InitProviderInterface;
/**
 * Peyedia list kontrak harga satuan.
 * 
 * @author zakyalvan
 */
class HargaSatuanContractListProvider extends AbstractContractListProvider {
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::init()
	 */
	public function init() {
		$this->validContextDataKeys[] = 'tipeKontrak';
		$this->contextDatas['tipeKontrak'] = Kontrak::TIPE_HARGA_SATUAN;
	}
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::buildQuery()
	 */
	protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		$queryBuilder->select('kontrak, vendor')
			->from('Contract\Entity\Kontrak\Kontrak', 'kontrak')
			->innerJoin('kontrak.vendor', 'vendor')
			->where($queryBuilder->expr()->andX('kontrak.tipeKontrak = :tipeKontrak'))
			->setParameter('tipeKontrak', $this->contextDatas['tipeKontrak']);
		return $queryBuilder->getQuery();
	}
}