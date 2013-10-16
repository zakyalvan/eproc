<?php
namespace Procurement\Entity\Tender;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_PGD_ITEM_PENAWARAN")
 * 
 * @author zakyalvan
 */
class ItemPenawaran {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_TENDER", type="string")
	 *
	 * @var string
	 */
	private $kodeTender;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KANTOR", type="string")
	 *
	 * @var string
	 */
	private $kodeKantor;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_VENDOR", type="integer")
	 *
	 * @var integer
	 */
	private $kodeVendor;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Procurement\Entity\Tender\Tender", fetch="LAZY", inversedBy="tenderVendors")
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
	 * @Orm\ManyToOne(targetEntity="Vendor\Entity\Vendor", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_VENDOR", referencedColumnName="KODE_VENDOR")
	 *
	 * @var Vendor
	 */
	private $vendor;
	public function getVendor() {
		return $this->vendor;
	}
	public function setVendor(Vendor $vendor) {
		$this->vendor = $vendor;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN", type="string", length=1024)
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
	 * @Orm\Column(name="JUMLAH", type="integer")
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
	 * @Orm\Column(name="HARGA", type="float")
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