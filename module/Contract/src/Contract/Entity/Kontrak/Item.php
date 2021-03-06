<?php
namespace Contract\Entity\Kontrak;

use Doctrine\ORM\Mapping as Orm;

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
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KONTRAK", type="string")
	 * 
	 * @var string
	 */
	private $kodeKontrak;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KANTOR", type="string")
	 *
	 * @var string
	 */
	private $kodeKantor;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Kontrak", fetch="LAZY", inversedBy="listItem")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", referencedColumnName="KODE_KONTRAK")})
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
	 * @Orm\Column(name="HARGA", type="float", nullable=true)
	 *
	 * @var float
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
		$this->jumlah = $jumlah;
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
	private $unit;
	public function getUnit() {
		return $this->unit;
	}
	public function setUnit($unit) {
		$this->unit = $unit;
	}
	
	/**
	 * @Orm\Column(name="SUB_TOTAL", type="float", nullable=true)
	 *
	 * @var float
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
	 * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
	 *
	 * @var \DateTime
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
	 * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
	 *
	 * @var \DateTime
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