<?php
namespace Contract\Service;

use Zend\Paginator\Paginator;

/**
 * Interface untuk pengambilan data kontrak.
 * 
 * @author zakyalvan
 */
interface ContractListProviderInterface {
	/**
	 * Set context data untuk list provider ini
	 * 
	 * @param array $contextDatas
	 */
	public function setContextDatas(array $contextDatas);
	
	/**
	 * Ambil daftar kontrak.
	 * 
	 * @return Paginator
	 */
	public function getContractList($pageNumber, $itemCountPerPage, $criterias = array());
}