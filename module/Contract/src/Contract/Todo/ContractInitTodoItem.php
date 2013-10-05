<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoItem;

/**
 * Kelas dto untuk todo item inisiasi kontrak.
 * 
 * @author zakyalvan
 */
class ContractInitTodoItem extends AbstractTodoItem {
	const TODO_ACTION_URL = "";
	
	public function __construct($kodePengadaan, $nomorPengadaan, $deskpripsiPekerjaan, $kodeVendor, $namaVendor, $tanggalPenetapan, $context, $createdDate) {
		parent::__construct($context, self::TODO_ACTION_URL, $createdDate);
	
		$this->kodePengadaan = $kodePengadaan;
		$this->nomorPengadaan = $nomorPengadaan;
		$this->deskripsiPekerjaan = $deskpripsiPekerjaan;
		$this->kodeVendor = $kodeVendor;
		$this->namaVendor = $namaVendor;
		$this->tanggalPenetapan = $tanggalPenetapan;
	}
	
	protected function formatActionUrl() {
		return '#';
	}
}