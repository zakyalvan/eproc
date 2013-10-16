<?php
namespace Procurement\Entity\Tender;

use Doctrine\ORM\Mapping as Orm;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_PGD_PENAWARAN")
 * 
 * @author zakyalvan
 */
class Penawaran {
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
	 * @Orm\OneToOne(targetEntity="Procurement\Entity\Tender\TenderVendor", fetch="LAZY", inversedBy="vendorStatus")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_TENDER", referencedColumnName="KODE_TENDER"), @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_VENDOR", referencedColumnName="KODE_VENDOR")})
	 * 
	 * @var TenderVendor
	 */
	private $tenderVendor;
	public function getTenderVendor() {
		return $this->tenderVendor;
	}
	public function setTenderVendor(TenderVendor $tenderVendor) {
		$this->tenderVendor = $tenderVendor;
	}
	
	/**
	 * @Orm\Column(name="NO_PENAWARAN", type="string", length=64)
	 * 
	 * @var string
	 */
	private $nomorPenawaran;
	public function getNomorPenawaran() {
		return $this->nomorPenawaran;
	}
	public function setNomorPenawaran($nomorPenawaran) {
		$this->nomorPenawaran = $nomorPenawaran;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Procurement\Entity\Tender\ItemPenawaran", fetch="LAZY", mappedBy="penawaran")
	 * 
	 * @var ArrayCollection
	 */
	private $listItem;
	public function getListItem() {
		return $this->listItem;
	}
	public function setListItem($listItem) {
		$this->listItem = $listItem;
	}
	
	/**
	 * @Orm\Column(name="TIPE", type="string", length=1)
	 * 
	 * @var string
	 */
	private $tipe;
	public function getTipe() {
		return $this->tipe;
	}
	public function setTipe($tipe) {
		$this->tipe = $tipe;
	}
	
	/**
	 * @Orm\Column(name="BID_BOND", type="integer")
	 * 
	 * @var integer
	 */
	private $bidBond;
	public function getBidBond() {
		return $this->bidBond;
	}
	public function setBidBond($bodBond) {
		$this->bidBond = $bodBond;
	}
	
	/**
	 * @Orm\Column(name="KANDUNGAN_LOKAL", type="integer")
	 * 
	 * @var integer
	 */
	private $kandunganLokal;
	public function getKandunganLokal() {
		return $this->kandunganLokal;
	}
	public function setKandunganLokal($kandunganLokal) {
		$this->kandunganLokal = $kandunganLokal;
	}
	
	/**
	 * @Orm\Column(name="WAKTU_PENGIRIMAN", type="integer")
	 * 
	 * @var integer
	 */
	private $waktuPengiriman;
	public function getWaktuPengiriman() {
		return $this->waktuPengiriman;
	}
	public function setWaktuPengiriman($waktuPengiriman)  {
		$this->waktuPengiriman = $waktuPengiriman;
	}
	
	/**
	 * @Orm\Column(name="UNIT", type="string", length=1)
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
	 * @Orm\Column(name="BERLAKU_HINGGA", type="datetime")
	 * 
	 * @var \DateTime
	 */
	private $berlakuHingga;
	public function getBerlakuHingga() {
		return $this->berlakuHingga;
	}
	public function setBerlakuHingga($berlakuHingga) {
		$this->berlakuHingga = $berlakuHingga;
	}
	
	/**
	 * @Orm\Column(name="LAMPIRAN", type="string", length=255)
	 * 
	 * @var string
	 */
	private $lampiran;
	public function getLampiran() {
		return $this->lampiran;
	}
	public function setLampiran($lampiran) {
		$this->lampiran = $lampiran;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN", type="string", length=4000)
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