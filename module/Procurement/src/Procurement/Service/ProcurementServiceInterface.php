<?php
namespace Procurement\Service;

use Procurement\Entity\Tender\Tender;

interface ProcurementServiceInterface {
	/**
	 * Apakah tender terdaftar dalam database.
	 * 
	 * @param Tender|array $tender
	 * @param boolean $throwException
	 * @return boolean
	 */
	public function isRegisteredTender($tender, $throwException = false);
	
	/**
	 * Retrieve registered tender. Jika object tender yang diberikan tidak valid, throw exception.
	 * 
	 * @param Tender|array $tender tender identity.
	 * @return Tender
	 */
	public function getRegisteredTender($tender);
	
	/**
	 * Apakah sebuah proses pengadaan sudah berakhir dengan pemenang tender.
	 * 
	 * @param Tender|array $tender
	 */
	public function isCompletedWithWinnerVendor($tender);
	
	/**
	 * Ambil data vendor pemenang proses pengadaan.
	 * 
	 * @param unknown $tender
	 */
	public function getWinnerVendor($tender);
}