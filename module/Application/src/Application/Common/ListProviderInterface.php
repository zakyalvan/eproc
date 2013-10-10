<?php
namespace Application\Common;

use Zend\Paginator\Paginator;
use Zend\Stdlib\InitializableInterface;
/**
 * Kontrak dasar untuk list data provider.
 * 
 * @author zakyalvan
 */
interface ListProviderInterface extends InitializableInterface {
	/**
	 * Set contex data untuk list-provider.
	 * 
	 * @param unknown $contexDatas
	 */
	public function setContextDatas($contexDatas);
	
	/**
	 * Retrieve list data.
	 * 
	 * @param unknown $currentPage
	 * @param unknown $itemCountPerPage
	 * @param unknown $criterias
	 * @return Paginator
	 */
	public function getListData($pageNumber, $itemCountPerPage, $criterias = array());
}