<?php
namespace Contract\Entity\Invoice;

use Doctrine\ORM\Mapping as Orm;
use Vendor\Entity\Vendor;

/**
 * Entity header dari invoice invoice
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_INVOICE")
 * 
 * @author zakyalvan
 */
class Invoice {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_INVOICE", type="string", length="50")
	 * 
	 * @var string
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
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Kontrak")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", type="string", length="5", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", length="50", referencedColumnName="KODE_KONTRAK")})
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
	 * @Id
	 * @ManyToOne(targetEntity="Vendor\Entity\Vendor", fetch="lazy")
	 * @JoinColumn(name="KODE_VENDOR", type="integer", referencedColumnName="KODE_VENDOR")
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
	 * @Column(name="TGL_INVOICE", type="date", nullable=true)
	 *
	 * @var date
	 */
	private $tanggalInvoice;
	public function getTanggalInvoice() {
		return $this->tanggalInvoice;
	}
	public function setTanggalInvoice($tanggalInvoice) {
		$this->tanggalInvoice = $tanggalInvoice;
	}
	
	/**
	 * @Column(name="NAMA_VENDOR", type="string", length="250", nullable=true)
	 *
	 * @var string
	 */
	private $namaVendor;
	public function getNamaVendor() {
		return $this->namaVendor;
	}
	public function setNamaVendor($namaVendor) {
		$this->namaVendor = $namaVendor;
	}
	
	/**
	 * @Column(name="AKUN_BANK", type="string", length="200", nullable=true)
	 *
	 * @var string
	 */
	private $akunBank;
	public function getAkunBank() {
		return $this->akunBank;
	}
	public function setAkunBank($akunBank) {
		$this->akunBank = $akunBank;
	}
	
	/**
	 * @Column(name="TGL_BUAT", type="date", nullable=true)
	 *
	 * @var date
	 */
	private $tanggalPembuatan;
	public function getTanggalPembuatan() {
		return $this->tanggalPembuatan;
	}
	public function setTanggalPembuatan($tanggalPembuatan) {
		$this->tanggalPembuatan = $tanggalPembuatan;
	}
	
	/**
	 * @Column(name="STATUS", type="string", length="2", nullable=true)
	 *
	 * @var string
	 */
	private $status;
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * @Column(name="POSISI_PERSETUJUAN", type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $posisiPersetujuan;
	public function getPosisiPersetujuan() {
		return $this->posisiPersetujuan;
	}
	public function setPosisiPersetujuan($posisiPersetujuan) {
		$this->posisiPersetujuan = $posisiPersetujuan;
	}
	
	/**
	 * @Column(name="TGL_DISETUJUI", type="date", nullable=true)
	 * 
	 * @var string
	 */
	private $tanggalDisetujui;
	public function getTanggalDisetujui() {
		return $this->tanggalDisetujui;
	}
	public function setTanggalDisetujui($tanggalDisetujui) {
		$this->tanggalDisetujui = $tanggalDisetujui;
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