<?php
namespace Procurement\Entity\Tender;

use Doctrine\ORM\Mapping as Orm;

/**
 * Item pengadaan/tender.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_PGD_ITEM_TENDER")
 * 
 * @author zakyalvan
 */
class Item {
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Procurement\Entity\Tender\Tender", fetch="lazy", inversedBy="listItem")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_TENDER", referencedColumnName="KODE_TENDER"), @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR")})
	 * 
	 * @var Tender
	 */
	private $tender;
	public function getTender() {
		return $this->tender;
	}
	public function setTender(Tender $tender) {
		$this->tender = $tender;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="NOMOR_URUT", type="integer")
	 *
	 * @var integer
	 */
	private $nomorUrut;
	public function getNomorUrut() {
		return $this->nomorUrut;
	}
	public function setNomorUrut($nomorUrut) {
		$this->nomorUrut = $nomorUrut;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN", type="string", length="1024", nullable=true)
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
	 * @Orm\Column(name="UNIT", type="string", length="50", nullable=true)
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
	 * @Orm\Column(name="PPN", type="string", length="1", nullable=true)
	 *
	 * @var string
	 */
	private $ppn;
	public function getPpn() {
		return $this->ppn;
	}
	public function isPpn() {
		return (strtoupper($this->ppn) == 'Y') ? true : false;
	}
	public function setPpn($ppn) {
		$this->ppn = $ppn;
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="date", nullable=true)
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
	 */
	private $petugasRekam;
	public function getPetugasRekam() {
		return $this->petugasRekam;
	}
	public function setPetugasRekam($petugasRekam) {
		$this->petugasRekam = $petugasRekam;
	}
	
	/**
	 * @Orm\Column(name="TGL_UBAH", type="date", nullable=true)
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
	 */
	private $petugasUbah;
	public function getPetugasUbah() {
		return $this->petugasUbah;
	}
	public function setPetugasUbah($petugasUbah) {
		$this->petugasUbah = $petugasUbah;
	}
}