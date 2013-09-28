<?php
namespace Contract\Entity\Po;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PO_PERKEMBANGAN")
 * 
 * @author zakyalvan
 */
class Perkembangan {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_PERKEMBANGAN", type="integer")
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
	 * @Orm\Column(name="TGL_PERKEMBANGAN", type="date", nullable=true)
	 * 
	 * @var date
	 */
	private $tanggalPerkembangan;
	public function getTanggalPerkembangan() {
		return $this->tanggalPerkembangan;
	}
	public function setTanggalPerkembangan($tanggalPerkembangan) {
		$this->tanggalPerkembangan = $tanggalPerkembangan;
	}
	
	/**
	 * @Orm\Column(name="TGL_BUAT", type="date", nullable=true)
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
	 * @Orm\Column(name="PEMBUAT", type="string", length="50", nullable=true)
	 *
	 * @var string
	 */
	private $pembuat;
	public function getPembuat() {
		return $this->pembuat;
	}
	public function setPembuat($pembuat) {
		$this->pembuat = $pembuat;
	}
	
	/**
	 * @Orm\Column(name="NAMA_PEMBUAT", type="string", length="250", nullable=true)
	 *
	 * @var string
	 */
	private $namaPembuat;
	public function getNamaPembuat() {
		return $this->namaPembuat;
	}
	public function setNamaPembuat($namaPembuat) {
		$this->namaPembuat = $namaPembuat;
	}
	
	/**
	 * @Orm\Column(name="STATUS", type="string", length="2", nullable=true)
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
	 * @Orm\Column(name="PERSENTASI_PERKEMBANGAN", type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $persentasiPerkembangan;
	public function getPersentasiPerkembangan() {
		return $this->persentasiPerkembangan;
	}
	public function setPersentasiPerkembangan($persentasiPerkembangan) {
		$this->persentasiPerkembangan = $persentasiPerkembangan;
	}
	
	/**
	 * @Orm\Column(name="POSISI_PERSETUJUAN", type="integer", nullable=true)
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
	 * @Orm\Column(name="KETERANGAN", type="string", length="4000", nullable=true)
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