<?php
namespace Procurement\Entity\Tender;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_PGD_TENDER_VENDOR_STATUS")
 * 
 * @author zakyalvan
 */
class VendorStatus {
	/**
	 * @Orm\Id
	 * @Orm\OneToOne(targetEntity="Procurement\Entity\Tender\TenderVendor", fetch="lazy", inversedBy="vendorStatus")
	 * @Orm\JoinColumns({@JoinColumn(name="KODE_TENDER", type="string", referencedColumnName="KODE_TENDER"), @JoinColumn(name="KODE_KANTOR", type="string", referencedColumnName="KODE_KANTOR"), , @JoinColumn(name="KODE_VENDOR", type="string", referencedColumnName="KODE_VENDOR")})
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
	 * @Orm\Column(name="STATUS", type="integer", nullable=true)
	 */
	private $status;
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * @Orm\Column(name="TEKNIKAL_STATUS", type="integer", nullable=true)
	 */
	private $teknikalStatus;
	public function setTeknikalStatus() {
		return $this->teknikalStatus;
	}
	public function setTeknikalStatus($teknikalStatus) {
		$this->teknikalStatus = $teknikalStatus;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN_TEKNIKAL", type="string", nullable=true)
	 */
	private $keteranganTeknikal;
	public function getKeteranganTeknikal() {
		return $this->keteranganTeknikal;
	}
	public function setKeteranganTeknikal($ketranganTeknikal) {
		$this->keteranganTeknikal = $ketranganTeknikal;
	}
	
	/**
	 * @Orm\Column(name="KOMERSIAL_STATUS", type="integer", nullable=true)
	 */
	private $komersialStatus;
	public function getKomersialStatus() {
		return $this->komersialStatus;
	}
	public function setKomersialStatus($komersialStatus) {
		$this->komersialStatus = $komersialStatus;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN_KOMERSIAL", type="string", nullable=true)
	 */
	private $keteranganKomersial;
	public function getKeteranganKomersial() {
		return $this->keteranganKomersial;
	}
	public function setKeteranganKomersial($keteranganKomersial) {
		$this->keteranganKomersial = $keteranganKomersial;
	}
	
	/**
	 * @Orm\Column(name="PEMENANG", type="string", nullable=true)
	 */
	private $pemenang;
	public function getPemenang() {
		return $this->pemenang;
	}
	public function setPemenang($pemenang) {
		$this->pemenang = $pemenang;
	}
	
	/**
	 * @Orm\Column(name="NEGOSIASI", type="integer", nullable=true)
	 */
	private $negosiasi;
	public function getNegosiasi() {
		return $this->negosiasi;
	}
	public function setNegosiasi($negosiasi) {
		$this->negosiasi = $negosiasi;
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