<?php
namespace Contract\Entity\Kontrak;

use Doctrine\ORM\Mapping as Orm;
use Vendor\Entity\Vendor;
use Procurement\Entity\Tender\Tender;
use Application\Entity\MataUang;
use Application\Entity\Kantor;

/**
 * Entity header dari sebuah kontrak.
 * 
 * @Orm\Entity(repositoryClass="Contract\Entity\Kontrak\Repository\KontrakRepository")
 * @Orm\Table(name="EP_KTR_KONTRAK")
 * 
 * @author zakyalvan
 */
class Kontrak {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KONTRAK", type="string")
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
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Kantor", fetch="lazy")
	 * @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR", type="string")
	 * 
	 * @var Kantor
	 */
	private $kantor;
	public function getKantor() {
		return $this->kantor;
	}
	public function setKantor(Kantor $kantor) {
		$this->kantor = $kantor;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Procurement\Entity\Tender\Tender", fetch="lazy")
	 * @Orm\JoinColumns({@JoinColumn(name="KODE_TENDER", type="string", referencedColumnName="KODE_TENDER"), @Orm\JoinColumn(name="KODE_KANTOR", type="string", referencedColumnName="KODE_KANTOR")})
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
	 * @Colum(name="NOMOR_KONTRAK", type="string", nullable=true)
	 */
	private $nomorKontrak;
	public function getNomorKontrak() {
		return $this->nomorKontrak;
	}
	public function setNomorKontrak($nomorKontrak) {
		$this->nomorKontrak = $nomorKontrak;
	}
	
	/**
	 * @Colum(name="USER_PEMINTA", type="string", nullable=true)
	 */
	private $userPeminta;
	public function getUserPeminta() {
		return $this->userPeminta;
	}
	public function setUserPeminta($userPeminta) {
		$this->userPeminta = $userPeminta;
	}
	
	/**
	 * @Colum(name="JABATAN_PEMINTA", type="string", nullable=true)
	 */
	private $jabatanPeminta;
	public function getJabatanPeminta() {
		return $this->jabatanPeminta;
	}
	public function setJabatanPeminta($jabatanPeminta) {
		$this->jabatanPeminta = $jabatanPeminta;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Vendor\Entity\Vendor", fetch="lazy")
	 * @Orm\JoinColumn(columnName="KODE_VENDOR", type="string", referencedColumnName="KODE_VENDOR")
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
	 * @Orm\Column(name="KODE_VENDOR", type="string", nullable=true)
	 */
	private $kodeVendor;
	public function getKodeVendor() {
		return $this->kodeVendor;
	}
	public function setKodeVendor($kodeVendor) {
		$this->kodeVendor = $kodeVendor;
	}
	
	/**
	 * @Orm\Column(name="NAMA_VENDOR", type="string", nullable=true)
	 */
	private $namaVendor;
	public function getNamaVendor() {
		return $this->namaVendor;
	}
	public function setNamaVendor($namaVendor) {
		$this->namaVendor = $namaVendor;
	}
	
	/**
	 * @Orm\Column(name="TGL_TTD", type="date", nullable=true)
	 */
	private $tanggalTandaTangan;
	public function getTanggalTandaTangan() {
		return $this->tanggalTandaTangan;
	}
	public function setTanggalTandaTangan($tanggalTandaTangan) {
		$this->tanggalTandaTangan = $tanggalTandaTangan;
	}
	
	/**
	 * @Orm\Column(name="TGL_MULAI", type="date", nullable=true)
	 */
	private $tanggalMulai;
	public function getTanggalMulai() {
		return $this->tanggalMulai;
	}
	public function setTanggalMulai($tanggalMulai) {
		$this->tanggalMulai = $tanggalMulai;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR", type="date", nullable=true)
	 */
	private $tanggalAkhir;
	public function getTanggalAkhir() {
		return $this->tanggalAkhir;
	}
	public function setTanggalAkhir($tanggalAkhir) {
		$this->tanggalAkhir = $tanggalAkhir;
	}
	
	/**
	 * @Orm\Column(name="TGL_BUAT", type="date", nullable=true)
	 */
	private $tanggalBuat;
	public function getTanggalBuat() {
		return $this->tanggalBuat;
	}
	public function setTanggalBuat($tanggalBuat) {
		$this->tanggalBuat = $tanggalBuat;
	}
	
	/**
	 * @Orm\Column(name="JUDUL_PEKERJAAN", type="string", nullable=true)
	 */
	private $judulPekerjaan;
	public function getJudulPekerjaan() {
		return $this->judulPekerjaan;
	}
	public function setJudulPekerjaan($judulPekerjaan) {
		$this->judulPekerjaan = $judulPekerjaan;
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
	 * @Orm\Column(name="JENIS_KONTRAK", type="string", nullable=true)
	 */
	private $jenisKontrak;
	public function getJenisKontrak() {
		return $this->jenisKontrak;
	}
	public function setJenisKontrak($jenisKontrak) {
		$this->jenisKontrak = $jenisKontrak;
	}
	
	/**
	 * @Orm\Column(name="PESANAN_ULANG", type="string", nullable=true)
	 */
	private $pesananUlang;
	public function getPesananUlang() {
		return $this->pesananUlang;
	}
	public function setPesananUlang($pesananUlang) {
		$this->pesananUlang = $pesananUlang;
	}
	
	/**
	 * @ManyToOne(targetEntity="Master\Entity\MataUang" fetch="lazy")
	 * @Orm\JoinColumn(name="MATA_UANG", type="string", referencedColumnName="MATA_UANG" nullable=true)
	 * 
	 * @var MataUang
	 */
	private $mataUang;
	public function getMataUang() {
		return $this->mataUang;
	}
	public function setMataUang($mataUang) {
		$this->mataUang = $mataUang;
	}
	
	/**
	 * @Orm\Column(name="NILAI_KONTRAK", type="double", nullable=true)
	 */
	private $nilaiKontrak;
	public function getNilaiKontrak() {
		return $this->nilaiKontrak;
	}
	public function setNilaiKontrak($nilaiKontrak) {
		$this->nilaiKontrak = $nilaiKontrak;
	}
	
	/**
	 * @Orm\Column(name="PERIODE_BAYAR_SEWA", type="integer", nullable=true)
	 */
	private $periodeBayarSewa;
	public function getPeriodeBayarSewa() {
		return $this->periodeBayarSewa;
	}
	public function setPeriodeBayarSewa($periodeBayarSewa) {
		$this->periodeBayarSewa = $periodeBayarSewa;
	}
	
	/**
	 * @Orm\Column(name="UNIT_BAYAR_SEWA", type="string", nullable=true)
	 */
	private $unitBayarSewa;
	public function getUnitBayarSewa() {
		return $this->unitBayarSewa;
	}
	public function setUnitBayarSewa($unitBayarSewa) {
		$this->unitBayarSewa = $unitBayarSewa;
	}
	
	/**
	 * @Orm\Column(name="TERMIN_BAYAR_SEWA", type="string", nullable=true)
	 */
	private $terminBayarSewa;
	public function getTerminBayarSewa() {
		return $this->terminBayarSewa;
	}
	public function setTerminBayarSewa($terminBayarSewa) {
		$this->terminBayarSewa = $terminBayarSewa;
	}
	
	/**
	 * @Orm\Column(name="STATUS", type="string", nullable=true)
	 */
	private $status;
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * @Orm\Column(name="TGL_PEMUTUSAN", type="date", nullable=true)
	 */
	private $tanggalPemutusan;
	public function getTanggalPemutusan() {
		return $this->tanggalPemutusan;
	}
	public function setTanggalPemutusan($tanggalPemutusan) {
		$this->tanggalPemutusan = $tanggalPemutusan;
	}
	
	/**
	 * @Orm\Column(name="POSISI_PERSETUJUAN", type="string", nullable=true)
	 */
	private $posisiPersetujuan;
	public function getPosisiPersetujuan() {
		return $this->posisiPersetujuan;
	}
	public function setPosisiPersetujuan($posisiPersetujuan) {
		$this->posisiPersetujuan = $posisiPersetujuan;
	}
	
	/**
	 * @Orm\Column(name="JUMLAH_PERUBAHAN", type="double", nullable=true)
	 */
	private $jumlahPerubahan;
	public function getJumlahPerubahan() {
		return $this->jumlahPerubahan;
	}
	public function setJumlahPerubahan($jumlahPerubahan) {
		$this->jumlahPerubahan = $jumlahPerubahan;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR_PENAWARAN", type="date", nullable=true)
	 */
	private $tanggalAkhirPenawaran;
	public function getTanggalAkhirPenawaran() {
		return $this->tanggalAkhirPenawaran;
	}
	public function setTanggalAlhirPenawaran($tanggalAkhirPenawaran) {
		$this->tanggalAkhirPenawaran = $tanggalAkhirPenawaran;
	}
	
	/**
	 * @Orm\Column(name="NILAI_JAMINAN", type="double", nullable=true)
	 */
	private $nilaiJaminan;
	public function getNilaiJaminan() {
		return $this->nilaiJaminan;
	}
	public function setNilaiJaminan($nilaiJaminan) {
		$this->nilaiJaminan = $nilaiJaminan;
	}
	
	/**
	 * @Orm\Column(name="BANK_JAMINAN", type="string", nullable=true)
	 */
	private $bankJaminan;
	public function getBankJaminan() {
		return $this->bankJaminan;
	}
	public function setBankJaminan($bankJaminan) {
		$this->bankJaminan = $bankJaminan;
	}
	
	/**
	 * @Orm\Column(name="NOMOR_JAMINAN", type="string", nullable=true)
	 */
	private $nomorJaminan;
	public function getNomorJaminan() {
		return $this->nomorJaminan;
	}
	public function setNomorJaminan($nomorJaminan) {
		$this->nomorJaminan = $nomorJaminan;
	}
	
	/**
	 * @Orm\Column(name="TGL_MULAI_JAMINAN", type="date", nullable=true)
	 */
	private $tanggalMulaiJaminan;
	public function getTanggalMulaiJaminan() {
		return $this->tanggalMulaiJaminan;
	}
	public function setTanggalMulaiJaminan($tanggalMulaiJaminan) {
		$this->tanggalMulaiJaminan = $tanggalMulaiJaminan;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR_JAMINAN", type="date", nullable=true)
	 */
	private $tanggalAkhirJaminan;
	public function getTanggalAkhirJaminan() {
		return $this->tanggalAkhirJaminan;
	}
	public function setTanggalAkhirJaminan($tanggalAkhirJaminan) {
		$this->tanggalAkhirJaminan = $tanggalAkhirJaminan;
	}
	
	/**
	 * @Orm\Column(name="LAMPIRAN_JAMINAN", type="string", nullable=true)
	 */
	private $lampiranJaminan;
	public function getLampiranJaminan() {
		return $this->lampiranJaminan;
	}
	public function setLampiranJaminan($lampiranJaminan) {
		$this->lampiranJaminan = $lampiranJaminan;
	}
	
	/**
	 * @Orm\Column(name="UM_PERSENTASI", type="integer", nullable=true)
	 */
	private $persentasiUangMuka;
	public function getPersentasiUangMuka() {
		return $this->persentasiUangMuka;
	}
	public function setPersentasiUangMuka($persentasiUangMuka) {
		$this->persentasiUangMuka = $persentasiUangMuka;
	}
	
	/**
	 * @Orm\Column(name="UM_NILAI", type="double", nullable=true)
	 */
	private $nilaiUangMuka;
	public function getNilaiUangMuka() {
		return $this->nilaiUangMuka;
	}
	public function setNilaiUangMuka($nilaiUangMuka) {
		$this->nilaiUangMuka = $nilaiUangMuka;
	}
	
	/**
	 * @Orm\Column(name="JABATAN_PEMBUAT", type="string", nullable=true)
	 */
	private $jabatanPembuat;
	public function getJabatanPembuat() {
		return $this->jabatanPembuat;
	}
	public function setJabatanPembuat($jabatanPembuat) {
		$this->jabatanPembuat = $jabatanPembuat;
	}
	
	/**
	 * @Orm\Column(name="ALASAN_PEMUTUSAN", type="string", nullable=true)
	 */
	private $alasanPemutusan;
	public function getAlasanPemutusan() {
		return $this->getAlasanPemutusan();
	}
	public function setAlasanPemutusan($alasanPemutusan) {
		$this->alasanPemutusan = $alasanPemutusan;
	}
	
	/**
	 * @Orm\Column(name="CATATAN_PEMUTUSAN", type="string", nullable=true)
	 */
	private $catatanPemutusan;
	public function getCatatanPemutusan() {
		return $this->catatanPemutusan;
	}
	public function setCatatanPemutusan($catatanPemutusan) {
		$this->catatanPemutusan = $catatanPemutusan;
	}
	
	/**
	 * @Orm\Column(name="LINGKUP_KERJA", type="string", nullable=true)
	 */
	private $lingkupKerja;
	public function getLingkupKerja() {
		return $this->lingkupKerja;
	}
	public function setLingkupKerja($lingkupKerja) {
		$this->lingkupKerja = $lingkupKerja;
	}
	
	/**
	 * @Orm\Column(name="CATATAN", type="string", nullable=true)
	 */
	private $catatan;
	public function getCatatan() {
		return $this->catatan;
	}
	public function setCatatan($catatan) {
		$this->catatan = $catatan;
	}
	
	/**
	 * @Orm\Column(name="DP_CATATAN", type="string", nullable=true)
	 */
	private $catatanUangMuka;
	public function getCatatanUangMuka() {
		return $this->catatanUangMuka;
	}
	public function setCatatanUangMuka($catatanUangMuka) {
		$this->catatanUangMuka = $catatanUangMuka;
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="date", nullable=true)
	 */
	private $tanggalRekam;
	public function getTanggalRekam() {
		return $this->tanggalRekam;
	}
	public function setTanggalRekam($tanggalRekam) {
		$this->tanggalRekam;
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