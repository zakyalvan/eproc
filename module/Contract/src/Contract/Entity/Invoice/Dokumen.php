<?php
namespace Contract\Entity\Invoice;

use Doctrine\ORM\Mapping as Orm;
use Vendor\Entity\Vendor;

/**
 * Document invoice.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_INVOICE_DOK")
 * 
 * @author zakyalvan
 */
class Dokumen {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_DOKUMEN", type="integer", length="64")
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
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Invoice\Invoice")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", type="string", length="5", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", length="50", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_INVOICE", type="string", length="50", referencedColumnName="KODE_INVOICE"), @Orm\JoinColumn(name="KODE_VENDOR", type="integer", referencedColumnName="KODE_VENDOR")})
	 *
	 * @var Invoice
	 */
	private $invoice;
	public function getInvoice() {
		return $this->invoice;
	}
	public function setInvoice(Invoice $invoice) {
		$this->invoice = $invoice;
	}
	
	/**
	 * @Orm\Column(name="KATEGORI", type="string", length="64", nullable=true)
	 *
	 * @var string
	 */
	private $kategori;
	public function getKategori() {
		return $this->kategori;
	}
	public function setKategori($kategori) {
		$this->kategori = $kategori;
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
	 * @Orm\Column(name="NAMA_FILE", type="string", length="255", nullable=true)
	 *
	 * @var string
	 */
	private $namaFile;
	public function getNamaFile() {
		return $this->namaFile;
	}
	public function setNamaFile($namaFile) {
		$this->namaFile = $namaFile;
	}
	
	/**
	 * @Orm\Column(name="STATUS", type="string", length="1", nullable=true)
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