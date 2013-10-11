<?php
namespace Application\Common;

use Zend\Paginator\Paginator;
/**
 * Kontrak dasar untuk list data provider.
 * 
 * @author zakyalvan
 */
interface ListProviderInterface {
	/**
	 * Set contex data untuk list-provider.
	 * 
	 * @param array $contexDatas
	 */
	public function setContextDatas($contexDatas);
	
	/**
	 * Retrieve list data.
	 * 
	 * @param integer $currentPage
	 * @param integer $itemCountPerPage
	 * @param array $criterias
	 * @return Paginator
	 */
	public function getListData($pageNumber, $itemCountPerPage, $criterias = array());
}