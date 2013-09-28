<?php
namespace Contract\Entity\Kontrak;

use Doctrine\ORM\Mapping as Orm;
use Master\Entity\SubKelompokBarang;

/**
 * Entity item kontrak
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_KONTRAK_ITEM")
 * 
 * @author zakyalvan
 */
class Item {
	/**
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Kontrak", fetch="lazy")
	 * @Orm\JoinColumns({@JoinColumn(name="KODE_KANTOR", type="string", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", referencedColumnName="KODE_KONTRAK")})
	 * 
	 * @var Kontrak
	 */
	private $kontrak;
	public function getKontrak() {
		return $this->kontrak;
	}
	public function setKontrak(Kontrak $kontrak) {
		$this->kontrak = $kontrak;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Master\Entity\SubKelompokBarang", fetch="lazy")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_BARANG_JASA", type="string",referencedColumnName="KODE_BARANG"), @Orm\JoinColumn(name="KODE_SUB_BARANG_JASA", referencedColumnName="KODE_KELOMPOK")})
	 * 
	 * @var SubKelompokBarang
	 */
	private $barang;
	public function getBarang() {
		return $this->barang;
	}
	public function setBarang(Barang $barang) {
		$this->barang = $barang;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN", type="string", nullable=true)
	 * 
	 * @var string
	 */
	private $keterangan;
	public function getKeterangan() {
		return $this->keterangan;
	}
	public function setKeterangan($keterangan) {
		$this->keterangan = $keterangan;
	}
	
	/**
	 * @Orm\Column(name="HARGA", type="double", nullable=true)
	 *
	 * @var double
	 */
	private $harga;
	public function getHarga() {
		return $this->harga;
	}
	public function setHarga($harga) {
		$this->harga = $harga;
	}
	
	/**
	 * @Orm\Column(name="JUMLAH", type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $jumlah;
	public function getJumlah() {
		return $this->jumlah;
	}
	public function setHarga($harga) {
		$this->harga = $harga;
	}
	
	/**
	 * @Orm\Column(name="MIN_QTY", type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $minimumQuantity;
	public function getMinimumQuantity() {
		return $this->minimumQuantity;
	}
	public function setMinimumQuantity($minimumQuantity) {
		$this->minimumQuantity = $minimumQuantity;
	}
	
	/**
	 * @Orm\Column(name="MAX_QTY", type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $maximumQuantity;
	public function getMaximumQuantity() {
		return $this->maximumQuantity;
	}
	public function setMaximumQuantity($maximumQuantity) {
		$this->maximumQuantity = $maximumQuantity;
	}
	
	/**
	 * @Orm\Column(name="SATUAN", type="string", nullable=true)
	 *
	 * @var string
	 */
	private $satuan;
	public function getSatuan() {
		return $this->satuan;
	}
	public function setSatuan($satuan) {
		$this->satuan = $satuan;
	}
	
	/**
	 * @Orm\Column(name="SUB_TOTAL", type="double", nullable=true)
	 *
	 * @var double
	 */
	private $subTotal;
	public function getSubTotal() {
		return $this->subTotal;
	}
	public function setSubTotal($subTotal) {
		$this->subTotal = $subTotal;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN_LENGKAP", type="string", nullable=true)
	 *
	 * @var string
	 */
	private $keteranganLengkap;
	public function getKeteranganLengkap() {
		return $this->keteranganLengkap;
	}
	public function setKeteranganLengkap($keteranganLengkap) {
		$this->keteranganLengkap = $keteranganLengkap;
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="date", nullable=true)
	 *
	 * @var date
	 */
	private $tanggalRekam;
	public function getTanggalRekam() {
		return $this->tanggalRekam;
	}
	public function setTanggalRekam($tanggalRekam) {
		$this->tanggalRekam = $tanggalRekam;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_REKAM", type="string", nullable=true)
	 *
	 * @var string
	 */
	private $petugasRekam;
	public function getPetugasRekam() {
		return $this->petugasUbah;
	}
	public function setPetugasRekam($petugasRekam) {
		$this->petugasRekam = $petugasRekam;
	}
	
	/**
	 * @Orm\Column(name="TGL_UBAH", type="date", nullable=true)
	 *
	 * @var date
	 */
	private $tanggalUbah;
	public function getTanggalUbah() {
		return $this->tanggalUbah;
	}
	public function setTanggalUbah($tanggalUbah) {
		$this->tanggalUbah = $tanggalUbah;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_UBAH", type="string", nullable=true)
	 *
	 * @var string
	 */
	private $petugasUbah;
	public function getPetugasUbah() {
		return $this->petugasUbah;
	}
	public function setPetugasUbah($petugasUbah) {
		$this->petugasUbah = $petugasUbah;
	}
}