<?php
namespace Contract\Entity\Perubahan;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity item perubahan.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PERUBAHAN_ITEM")
 * 
 * @author zakyalvan
 */
class Item {
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Perubahan\Perubahan")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_PERUBAHAN", type="integer", referencedColumnName="KODE_PERUBAHAN"), @Orm\JoinColumn(name="KODE_KANTOR", type="string", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", referencedColumnName="KODE_KONTRAK")})
	 * 
	 * @var Perubahan
	 */
	private $perubahan;
	public function getPerubahan() {
		return $this->perubahan;
	}
	public function setPerubahan(Perubahan $perubahan) {
		$this->perubahan = $perubahan;
	}
	
	
	/**
	 * @Orm\Column(name="KETERANGAN", type="string", length="255", nullable=true)
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
	public function setJumlah($jumlah) {
		$this->jumlah;
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
	private $maksimumQuantity;
	public function getMaksimumQuantity() {
		return $this->maksimumQuantity;
	}
	public function setMaksimumQuantity($maksimumQuantity) {
		$this->maksimumQuantity = $maksimumQuantity;
	}
	
	/**
	 * @Orm\Column(name="SATUAN", type="string", length="10", nullable=true)
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
	 * @Orm\Column(name="KETERANGAN_LENGKAP", type="string", length="4000", nullable=true)
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