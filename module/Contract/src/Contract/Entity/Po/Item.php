<?php
namespace Contract\Entity\Po;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity header dari PO
 *
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PO_ITEM")
 *
 * @author zakyalvan
 */
class Item {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_PO_ITEM", type="integer")
	 * @Orm\GeneratedValue(strategy="NONE")
	 * 
	 * @var integer
	 */
	private $kode;
	public function getKode() {
		return $this->kode;
	}
	public function setKode($kode) {
		$this->kode = $kode;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Kontrak", fetch="lazy")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", type="string", length="5", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", length="50", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_PO", type="string", length="50", referencedColumnName="KODE_PO")})
	 * 
	 * @var Po
	 */
	private $po;
	public function getPo() {
		return $this->po;
	}
	public function setPo(Po $po) {
		$this->po = $po;
	}
	
	/**
	 * @Orm\Column(name="KETERNGAN", type="string", length="255", nullable=true)
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
	 * @Orm\Column(name="QTY", type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $quantity;
	public function getQuantity() {
		return $this->quantity;
	}
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
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
	 * @Orm\Column(name="KETERNGAN_LENGKAP", type="string", length="4000", nullable=true)
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