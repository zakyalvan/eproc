<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoItem;

/**
 * Dto object untuk todo item pembuatan kontrak.
 * 
 * @author zakyalvan
 */
class ContractCreateTodoItem extends AbstractTodoItem {
	public function __construct($kodeKontrak, $deskripsiPekerjaan, $kodeVendor, $namaVendor, $statusProses, $context, $actionUrl, $createdDate) {
		parent::__construct($context, $actionUrl, $createdDate);
		
		$this->kodeKontrak = $kodeKontrak;
		$this->deskripsiPekerjaan = $deskripsiPekerjaan;
		$this->kodeVendor = $kodeVendor;
		$this->namaVendor = $namaVendor;
		$this->statusProses = $statusProses;
	}
	
	public function formatActionUrl() {
		return '#';
	}
}