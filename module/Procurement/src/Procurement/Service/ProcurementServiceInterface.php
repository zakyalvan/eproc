<?php
namespace Procurement\Service;

interface ProcurementServiceInterface {
	/**
	 * Apakah tender terdaftar dalam database.
	 * 
	 * @param Tender|array $tender
	 * @param bool $throwException
	 */
	public function isRegisteredTender($tender, $throwException = false);
	
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