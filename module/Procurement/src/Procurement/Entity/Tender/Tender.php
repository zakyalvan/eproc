<?php
namespace Procurement\Entity\Tender;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_PGD_TENDER")
 * 
 * @author zakyalvan
 */
class Tender {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_TENDER", type="string", nullable=false)
	 */
	private $kodeTender;
	public function getKodeTender() {
		return $this->kodeTender;
	}
	public function setKodeTender($kodeTender) {
		$this->kodeTender = $kodeTender;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Procurement\Entity\Tender\TenderVendor", fetch="lazy", mappedBy="tender")
	 * 
	 * Array dari vendor untuk tender ini.
	 */
	private $tenderVendors;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KANTOR", type="string", nullable=false)
	 */
	private $kodeKantor;
	public function getKodeKantor() {
		return $this->kodeKantor;
	}
	public function setKodeKantor($kodeKantor) {
		$this->kodeKantor = $kodeKantor;
	}
	
	/**
	 * @Orm\Column(name="KODE_TENDER_SEBELUM", type="string", nullable=true)
	 */
	private $kodeTenderSebelum;
	public function getKodeTenderSebelum() {
		return $this->kodeTenderSebelum;
	}
	public function setKodeTenderSebelum($kodeTenderSebelum) {
		$this->kodeTenderSebelum = $kodeTenderSebelum;
	}
	
	/**
	 * @Orm\Column(name="KODE_TENDER_SESUDAH", type="string", nullable=true)
	 */
	private $kodeTenderSesudah;
	public function getKodeTenderSesudah() {
		return $this->kodeTenderSesudah;
	}
	public function setKodeTenderSesudah($kodeTenderSesudah) {
		$this->kodeTenderSesudah = $kodeTenderSesudah;
	}
	/**
	 * @Orm\Column(name="NAMA_PEMOHON", type="string", nullable=true)
	 */
	private $namaPemohon;
	public function getNamaPemohon() {
		return $this->namaPemohon;
	}
	public function setNamaPemohon($namaPemohon) {
		$this->namaPemohon = $namaPemohon;
	}
	
	/**
	 * @Orm\Column(name="KODE_JAB_PEMOHON", type="string", nullable=true)
	 */
	private $kodeJabatanPemohon;
	public function getKodeJabatanPemohon() {
		return $this->kodeJabatanPemohon;
	}
	public function setKodeJabatanPemohon($kodeJabatanPemohon) {
		$this->kodeJabatanPemohon = $kodeJabatanPemohon;
	}
	
	/**
	 * @Orm\Column(name="NAMA_PERENCANA", type="string", nullable=true)
	 */
	private $namaPerencana;
	public function getNamaPerencana() {
		return $this->namaPerencana;
	}
	public function setNamaPerencana($namaPerencana) {
		$this->namaPerencana = $namaPerencana;
	}
	
	/**
	 * @Orm\Column(name="KODE_JAB_PERENCANA", type="string", nullable=true)
	 */
	private $kodeJabatanPerencana;
	public function getKodeJabatanPerencana() {
		return $this->kodeJabatanPerencana;
	}
	public function setKodeJabatanPerencana($kodeJabatanPerencana) {
		$this->kodeJabatanPerencana;
	}
	
	/**
	 * @Orm\Column(name="NAMA_PELAKSANA", type="string", nullable=true)
	 */
	private $namaPelaksana;
	public function getNamaPelaksana() {
		return $this->namaPelaksana;
	}
	public function setNamaPelaksana($namaPelaksana) {
		$this->namaPelaksana = $namaPelaksana;
	}
	
	/**
	 * @Orm\Column(name="KODE_JAB_PELAKSANA", type="string", nullable=true)
	 */
	private $kodeJabatanPelaksana;
	public function getKodeJabatanPelaksana() {
		return $this->kodeJabatanPelaksana;
	}
	public function setKodeJabatanPelaksana($kodeJabatanPelaksana) {
		$this->kodeJabatanPelaksana = $kodeJabatanPelaksana;
	}
	
	/**
	 * @Orm\Column(name="TGL_PEMBUATAN", type="date", nullable=true)
	 */
	private $tanggalPembutan;
	public function getTanggalPembuatan() {
		return $this->tanggalPembutan;
	}
	public function setTanggalPembuatan($tanggalPembuatan) {
		$this->tanggalPembutan = $tanggalPembuatan;
	}
	
	/**
	 * @Orm\Column(name="JUDUL_PEKERJAAN", type="string", nullable=true)
	 */
	private $judulPekerjaan;
	public function getJudulPekerjaan() {
		return $this->judulPekerjaan;
	}
	public function setJudulPekerjaan($juduPekerjaan) {
		$this->judulPekerjaan = $juduPekerjaan;
	}
	
	/**
	 * @Orm\Column(name="LINGKUP_PEKERJAAN", type="string", nullable=true)
	 */
	private $lingkupPekerjaan;
	public function getLingkupPekerjaan() {
		return $this->lingkupPekerjaan;
	}
	public function setLingkupPekerjaan($lingkupPekerjaan) {
		$this->lingkupPekerjaan = $lingkupPekerjaan;
	}
	
	/**
	 * @Orm\Column(name="WAKTU_PENGIRIMAN", type="integer", nullable=true)
	 */
	private $waktuPengiriman;
	public function getWaktuPengiriman() {
		return $this->waktuPengiriman;
	}
	public function setWaktuPengiriman($waktuPengiriman) {
		$this->waktuPengiriman = $waktuPengiriman;
	}
	
	/**
	 * @Orm\Column(name="UNIT_PENGIRIMAN", type="integer", nullable=true)
	 */
	private $unitPengiriman;
	public function getUnitPengiriman() {
		return $this->unitPengiriman;
	}
	public function setUnitPengiriman($unitPengiriman) {
		$this->unitPengiriman = $unitPengiriman;
	}
	
	/**
	 * @Orm\Column(name="NAMA_PEMEBELI", type="string", nullable=true)
	 */
	private $namaPembeli;
	public function getNamaPembeli() {
		return $this->namaPembeli;
	}
	public function setNamaPembeli($namaPembeli) {
		$this->namaPembeli = $namaPembeli;
	}
	
	/**
	 * @Orm\Column(name="KODE_JAB_PEMBELI", type="string", nullable=true)
	 */
	private $kodeJabatanPembeli;
	public function getKodeJabatanPembeli() {
		return $this->kodeJabatanPembeli;
	}
	public function setKodeJabatanPembeli($kodeJabatanPembeli) {
		$this->kodeJabatanPembeli = $kodeJabatanPembeli;
	}
	
	/**
	 * @Orm\Column(name="MATA_UANG", type="string", nullable=true)
	 */
	private $mataUang;
	public function getMataUang() {
		return $this->mataUang;
	}
	public function setMataUang($mataUang) {
		$this->mataUang = $mataUang;
	}
	
	/**
	 * @Orm\Column(name="TIPE_KONTRAK", type="string", nullable=true)
	 */
	private $tipeKontrak;
	public function getTipeKontrak() {
		return $this->tipeKontrak;
	}
	public function setTipeKontrak($tipeKontrak) {
		$this->tipeKontrak = $tipeKontrak;
	}
	
	/**
	 * @Orm\Column(name="NAMA_JABATAN_PESERTA", type="string", nullable=true)
	 */
	private $namaJabatanPeserta;
	public function getNamaJabatanPeserta() {
		return $this->namaJabatanPeserta;
	}
	public function setNamaJabatanPeserta($namaJabatanPeserta) {
		$this->namaJabatanPeserta = $namaJabatanPeserta;
	}
	
	/**
	 * @Orm\Column(name="KODE_JABATAN_PESERTA", type="string", nullable=true)
	 */
	private $kodeJabatanPeserta;
	public function getKodeJabatanPeserta() {
		return $this->kodeJabatanPeserta;
	}
	public function setKodeJabatanPeserta($kodeJabatanPeserta) {
		$this->kodeJabatanPeserta = $kodeJabatanPeserta;
	}
	
	/**
	 * @Orm\Column(name="PEMBUATAN_KONTRAK", type="string", nullable=true)
	 */
	private $pembutanKontrak;
	public function getPembutanKontrak() {
		return $this->pembutanKontrak;
	}
	public function setPembutanKontrak($pembutanKontrak) {
		$this->pembutanKontrak = $pembutanKontrak;
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
	 * @Orm\Column(name="TGL_SELESAI", type="date", nullable=true)
	 */
	private $tanggalSelesai;
	public function getTanggalSelesai() {
		return $this->tanggalSelesai;
	}
	public function setTanggalSelesai($tanggalSelesai) {
		$this->tanggalSelesai = $tanggalSelesai;
	}
	
	/**
	 * @Orm\Column(name="KODE_PERENCANAAN", type="integer", nullable=true)
	 */
	private $kodePerencanaan;
	public function getKodePerencanaan() {
		return $this->kodePerencanaan;
	}
	public function setKodePerencanaan($kodePerencanaan) {
		$this->kodePerencanaan = $kodePerencanaan;
	}
	
	/**
	 * @Orm\Column(name="KODE_KANTOR_PERENCANAAN", type="string", nullable=true)
	 */
	private $kodeKantorPerencanaan;
	public function getKodeKantorPerencanaan() {
		return $this->kodeKantorPerencanaan;
	}
	public function setKodeKantorPerencanaan($kodeKantorPerencanaan) {
		$this->kodeKantorPerencanaan = $kodeKantorPerencanaan;
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
	
	/**
	 * @Orm\Column(name="KODE_KANTOR_KIRIM", type="string", nullable=true)
	 */
	private $kodeKantorKirim;
	public function getKodeKantorKirim() {
		return $this->kodeKantorKirim;
	}
	public function setKodeKantorKirim($kodeKantorKirim) {
		$this->kodeKantorKirim = $kodeKantorKirim;
	}
	
	/**
	 * @Orm\Column(name="STATUS_MANUAL", type="string", nullable=true)
	 */
	private $statusManual;
	public function getStatusManual() {
		return $this->statusManual;
	}
	public function setStatusManual($statusManual) {
		$this->statusManual = $statusManual;
	}
	
	/**
	 * @Orm\Column(name="KEGIATAN_ID", type="string", nullable=true)
	 */
	private $kegiatanId;
	public function getKegiatanId() {
		return $this->kegiatanId;
	}
	public function setKegiatanId($kegiatanId) {
		$this->kegiatanId = $kegiatanId;
	}
	
	/**
	 * @Orm\Column(name="KODE_USER_PERENCANA", type="string", nullable=true)
	 */
	private $kodeUserPerencana;
	public function getKodeUserPerencana() {
		return $this->kodeUserPerencana;
	}
	public function setKodeUserPerencana($kodeUserPerencana) {
		$this->kodeUserPerencana = $kodeUserPerencana;
	}
	
	/**
	 * @Orm\Column(name="KODE_USER_PELAKSANA", type="string", nullable=true)
	 */
	private $kodeUserPelaksana;
	public function getKodeUserPelaksana() {
		return $this->kodeUserPelaksana;
	}
	public function setKodeUserPelaksana($kodeUserPelaksana) {
		$this->kodeUserPelaksana = $kodeUserPelaksana;
	}
	
	/**
	 * @Orm\Column(name="KODE_USER_PEMOHON", type="string", nullable=true)
	 */
	private $kodeUserPemohon;
	public function getKodeUserPemohon() {
		return $this->kodeUserPemohon;
	}
	public function setKodeUserPemohon($kodeUserPemohon) {
		$this->kodeUserPemohon = $kodeUserPemohon;
	}
	
}