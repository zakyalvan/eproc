<?php
namespace Contract\Entity\Jangka;

use Doctrine\ORM\Mapping as Orm;
use Contract\Entity\Kontrak\Kontrak;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_JANGKA_KONTRAK")
 * 
 * @author zakyalvan
 */
class JangkaKontrak {
	/**
	 * Kode jangka.
	 * 
	 * @Orm\Id
	 * @Orm\Column(name="KODE_JANGKA", type="integer")
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
	 * @Orm\ManyToOne(targetEntity="Kontrak\Entity\Kontrak\Kontrak", fetch="lazy")
	 * @Orm\JoinColumns({@JoinColumn(name="KODE_KANTOR", type="string", length="5", referencedColumnName="KODE_KANTOR"), @JoinColumn(name="KODE_KONTRAK", type="string", length="50", referencedColumnName="KODE_KONTRAK")})
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
	 * @Orm\Column(name="PERSENTASI", type="integer", nullable=true)
	 * 
	 * @var integer
	 */
	private $persentasi;
	public function getPersentasi() {
		return $this->persentasi;
	}
	public function setPersentasi($persentasi) {
		$this->persentasi = $persentasi;
	}
	
	/**
	 * @Orm\Column(name="TGL_TARGET", type="date", nullable=true)
	 *
	 * @var date
	 */
	private $tanggalTarget;
	public function getTanggalTarget() {
		return $this->tanggalTarget;
	}
	public function setTanggalTarget($tanggalTaget) {
		$this->tanggalTarget = $tanggalTaget;
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
	 * @Orm\Column(name="STATUS_PERKEMBANGAN", type="string", length="2", nullable=true)
	 *
	 * @var string
	 */
	private $statusPerkembangan;
	public function getStatusPerkembangan() {
		return $this->statusPerkembangan;
	}
	public function setStatusPerkembangan($statusPerkembangan) {
		$this->statusPerkembangan = $statusPerkembangan;
	}
	
	/**
	 * @Orm\Column(name="NO_BASTP", type="string", length="50", nullable=true)
	 *
	 * @var string
	 */
	private $nomorBastp;
	public function getNomorBastp() {
		return $this->nomorBastp;
	}
	public function setNomorBastp($nomorBastp) {
		$this->nomorBastp = $nomorBastp;
	}
	
	/**
	 * @Orm\Column(name="TGL_BASTP", type="date", nullable=true)
	 *
	 * @var date
	 */
	private $tanggalBastp;
	public function getTanggalBastp() {
		return $this->tanggalBastp;
	}
	public function setTanggalBastp($tanggalBastp) {
		$this->tanggalBastp = $tanggalBastp;
	}
	
	/**
	 * @Orm\Column(name="JUDUL_BASTP", type="string", length="1024", nullable=true)
	 *
	 * @var string
	 */
	private $judulBastp;
	public function getJudulBastp() {
		return $this->judulBastp;
	}
	public function setJudulBastp($judulBastp) {
		$this->judulBastp = $judulBastp;
	} 
	
	/**
	 * @Orm\Column(name="LAMPIRAN_BASTP", type="string", length="250", nullable=true)
	 *
	 * @var string
	 */
	private $lampiranBastp;
	public function getLampiranBastp() {
		return $this->lampiranBastp;
	}
	public function setLampiranBastp($lampiranBastp) {
		$this->lampiranBastp = $lampiranBastp;
	}
	
	/**
	 * @Orm\Column(name="TGL_BUAT_BASTP", type="date", nullable=true)
	 *
	 * @var date
	 */
	private $tanggalPembuatanBastp;
	public function getTanggalPembuatanBastp() {
		return $this->tanggalPembuatanBastp;
	}
	public function setTanggalPembuatanBastp($tanggalPembuatanBastp) {
		$this->tanggalPembuatanBastp = $tanggalPembuatanBastp;
	}
	
	/**
	 * @Orm\Column(name="STATUS_BASTP", type="string", length="2", nullable=true)
	 *
	 * @var string
	 */
	private $statusBastp;
	public function getStatusBastp() {
		return $this->statusBastp;
	}
	public function setStatusBastp($statusBastp) {
		$this->statusBastp = $statusBastp;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN_BASTP", type="string", length="4000", nullable=true)
	 *
	 * @var string
	 */
	private $keteranganBastp;
	public function getKeteranganBastp() {
		return $this->keteranganBastp;
	}
	public function setKeteranganBastp($keteranganBastp) {
		$this->keteranganBastp = $keteranganBastp;
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
	 * @Orm\Column(name="DP_PERSENTASI", type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $persentasiUangMuka;
	public function getPersentasiUangMuka() {
		return $this->persentasiUangMuka;
	}
	public function setPersentasiUangMuka($persentasiUangMuka) {
		$this->persentasiUangMuka = $persentasiUangMuka;
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
	 * @Orm\Column(name="JUMLAH_UANG", type="double", nullable=true)
	 *
	 * @var double
	 */
	private $jumlahUang;
	public function getJumlahUang() {
		return $this->jumlahUang;
	}
	public function setJumlahUang($jumlahUang) {
		$this->jumlahUang = $jumlahUang;
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