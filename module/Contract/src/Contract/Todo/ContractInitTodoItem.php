<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoItem;

/**
 * Kelas dto untuk todo item inisiasi kontrak.
 * 
 * @author zakyalvan
 */
class ContractInitTodoItem extends AbstractTodoItem {
	/**
	 * Kode pengadaan.
	 * 
	 * @var string
	 */
	private $kodeTender;
	public function getKodeTender() {
		return $this->kodeTender;
	}
	protected function setKodeTender($kodeTender) {
		$this->kodeTender = $kodeTender;
	}
	
	/**
	 * Kode kantor.
	 * 
	 * @var string
	 */
	private $kodeKantor;
	public function getKodeKantor() {
		return $this->kodeKantor;
	}
	protected function setKodeKantor($kodeKantor) {
		$this->kodeKantor = $kodeKantor;
	}
	
	/**
	 * Judul pekerjaan.
	 * 
	 * @var string
	 */
	private $judulPekerjaan;
	public function getJudulPekerjaan() {
		return $this->judulPekerjaan;
	}
	protected function setJudulPekerjaan($judulPekerjaan) {
		$this->judulPekerjaan = $judulPekerjaan;
	}
	
	/**
	 * Lingkup pekerjaan.
	 * 
	 * @var string
	 */
	private $lingkupPekerjaan;
	public function getLingkupPekerjaan() {
		return $this->lingkupPekerjaan;
	}
	protected function setLingkupPekerjaan($lingkupPekerjaan) {
		$this->lingkupPekerjaan = $lingkupPekerjaan;
	}
	
	/**
	 * Kode vendor.
	 * 
	 * @var integer
	 */
	private $kodeVendor;
	public function getKodeVendor() {
		return $this->kodeVendor;
	}
	protected function setKodeVendor($kodeVendor) {
		$this->kodeVendor = $kodeVendor;
	}
	
	/**
	 * Nama vendor pemenang pengadaan.
	 * 
	 * @var String
	 */
	private $namaVendor;
	public function getNamaVendor() {
		return $this->namaVendor;
	}
	protected function setNamaVendor($namaVendor) {
		$this->namaVendor = $namaVendor;
	}
	
	/**
	 * Tanggal penetapan pemenang.
	 * 
	 * @var \DateTime
	 */
	private $tanggalPenetapan;
	public function getTanggalPenetapan() {
		return $this->tanggalPenetapan;
	}
	protected function setTanggalPenetapan($tanggalPenetapan) {
		$this->tanggalPenetapan = $tanggalPenetapan;
	}
	
	public function __construct($kodeTender, $kodeKantor, $judulPekerjaan, $lingkupPekerjaan, $kodeVendor, $namaVendor, $tanggalPenetapan) {
		parent::__construct('ContractInit', 'contract/init', array('tender' => $kodeTender, 'kantor' => $kodeKantor), null, $tanggalPenetapan);
		
		$this->setKodeTender($kodeTender);
		$this->setKodeKantor($kodeKantor);
		$this->setJudulPekerjaan($judulPekerjaan);
		$this->setLingkupPekerjaan($lingkupPekerjaan);
		$this->setKodeVendor($kodeVendor);
		$this->setNamaVendor($namaVendor);
		$this->setTanggalPenetapan($tanggalPenetapan);
	}
}