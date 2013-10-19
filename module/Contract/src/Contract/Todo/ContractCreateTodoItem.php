<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoItem;

/**
 * Dto object untuk todo item pembuatan kontrak.
 * 
 * @author zakyalvan
 */
class ContractCreateTodoItem extends AbstractTodoItem {
	public function __construct($kodeTender, $kodeKantor, $judulPekerjaan, $kodeVendor, $namaVendor, $statusProses, $createdDate) {
		parent::__construct('', '', array(), '', $createdDate);
		
		$this->setKodeTender($kodeTender);
		$this->setKodeKantor($kodeKantor);
		$this->setJudulPekerjaan($judulPekerjaan);
		$this->setNamaVendor($namaVendor);
		$this->setKodeVendor($kodeVendor);
		$this->setStatusProses($statusProses);
		
		$this->setActionRoute('contract/create');
		$this->setActionRouteParams(array(
			'tender' => $this->kodeTender,
			'kantor' => $this->kodeKantor
		));
	}
	
	private $kodeTender;
	public function getKodeTender() {
		return $this->kodeTender;
	}
	protected function setKodeTender($kodeTender) {
		$this->kodeTender = $kodeTender;
	}
	
	private $kodeKantor;
	public function getKodeKantor() {
		return $this->kodeKantor;
	}
	protected function setKodeKantor($kodeKantor) {
		$this->kodeKantor = $kodeKantor;
	}
	
	private $judulPekerjaan;
	public function getJudulPekerjaan() {
		return $this->judulPekerjaan;
	}
	protected function setJudulPekerjaan($judulPekerjaan) {
		$this->judulPekerjaan = $judulPekerjaan;
	}
	
	private $kodeVendor;
	public function getKodeVendor() {
		return $this->kodeVendor;
	}
	protected function setKodeVendor($kodeVendor) {
		$this->kodeVendor = $kodeVendor;
	}
	
	private $namaVendor;
	public function getNamaVendor() {
		return $this->namaVendor;
	}
	protected function setNamaVendor($namaVendor) {
		$this->namaVendor = $namaVendor;
	}
	
	private $statusProses;
	public function getStatusProses() {
		return $this->statusProses;
	}
	protected function setStatusProses($statusProses) {
		$this->statusProses = $statusProses;
	}
}