<?php
namespace Contract\Entity\Perubahan;

use Doctrine\ORM\Mapping as Orm;
use Contract\Entity\Kontrak\Kontrak;
use Application\Entity\MataUang;

/**
 * Entity yang mewakili table header sebuah adendum.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PERUBAHAN")
 * 
 * @author zakyalvan
 */
class Perubahan {
	/**
	 * Kode perubahan
	 * 
	 * @Orm\Column(name="KODE_PERUBAHAN", type="integer", nullable=true)
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
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Kontrak", fetch="lazy")
	 * @Orm\JoinColumns({@JoinColumn(name="KODE_KANTOR", type="string", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", referencedColumnName="KODE_KONTRAK")})
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
	 * @Orm\Column(name="TGL_MULAI_SEBELUM", type="date", nullable=true)
	 */
	private $tanggalMulaiSebelum;
	public function getTanggalMulaiSebelum() {
		return $this->tanggalMulaiSebelum;
	}
	public function setTanggalMulaiSebelum($tanggalMulaiSebelum) {
		$this->tanggalMulaiSebelum = $tanggalMulaiSebelum;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR", type="date", nullable=true)
	 */
	private $tanggalAkhir;
	public function getTanggalAlhir() {
		return $this->tanggalAkhir;
	}
	public function setTanggalAkhir($tanggalAkhir) {
		$this->tanggalAkhir = $tanggalAkhir;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR_SEBELUM", type="date", nullable=true)
	 */
	private $tanggalAkhirSebelum;
	public function getTanggalAkhirSebelum() {
		return $this->tanggalAkhirSebelum;
	}
	public function setTanggalAkhirSebelum($tanggalAkhirSebelum) {
		$this->tanggalAkhirSebelum = $tanggalAkhirSebelum;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Master\Entity\MataUang", fetch="eager")
	 * @Orm\JoinColumn(name="TGL_MULAI", type="string", referencedColumnName="MATA_UANG", nullable=true)
	 */
	private $mataUang;
	public function getMataUang() {
		return $this->mataUang;
	}
	public function setMataUang(MataUang $mataUang) {
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
	 * @Orm\Column(name="NILAI_KONTRAK_SEBELUM", type="double", nullable=true)
	 */
	private $nilaiKontrakSebelum;
	public function getNilaiKontrakSebelum() {
		return $this->nilaiKontrakSebelum;
	}
	public function setNilaiKontrakSebelum($nilaiKontrakSebelum) {
		$this->nilaiKontrakSebelum = $nilaiKontrakSebelum;
	}
	
	/**
	 * @Orm\Column(name="STATUS", type="string", length="2", nullable=true)
	 */
	private $status;
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * @Orm\Column(name="POSISI_PERSETUJUAN", type="string", length="50", nullable=true)
	 */
	private $posisiPersetujuan;
	public function getPosisiPersetujuan() {
		return $this->posisiPersetujuan;
	}
	public function setPosisiPersetujuan($posisiPersetujuan) {
		$this->posisiPersetujuan = $posisiPersetujuan;
	}
	
	/**
	 * @Orm\Column(name="TGL_PERUBAHAN", type="date", nullable=true)
	 */
	private $tanggalPerubahan;
	public function getTanggalPerubahan() {
		return $this->tanggalPerubahan;
	}
	public function setTanggalPerubahan($tanggalPerubahan) {
		$this->tanggalPerubahan = $tanggalPerubahan;
	}
	
	/**
	 * @Orm\Column(name="TIPE_"KONTRAK, type="string", length="50", nullable=true)
	 */
	private $tipeKontrak;
	public function getTipeKontrak() {
		return $this->tipeKontrak;
	}
	public function setTipeKontrak($tipeKontrak) {
		$this->tipeKontrak = $tipeKontrak;
	}
	
	/**
	 * @Orm\Column(name="JENIS_KONTRAK", type="string", length="50", nullable=true)
	 */
	private $jenisKontrak;
	public function getJenisKontrak() {
		return $this->jenisKontrak;
	}
	public function setJenisKontrak($jenisKontrak) {
		$this->jenisKontrak = $jenisKontrak;
	} 
	
	/**
	 * @Orm\Column(name="NO_KONTRAK", type="string", length="50", nullable=true)
	 */
	private $nomorKontrak;
	public function getNomorKontrak() {
		return $this->nomorKontrak;
	}
	public function setNomorKontrak($nomorKontrak) {
		$this->nomorKontrak = $nomorKontrak;
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
	 * @Orm\Column(name="UNIT_BAYAR_SEWA", type="string", length="50", nullable=true)
	 */
	private $unitBayarSewa;
	public function getUnitBayarSewa() {
		return $this->unitBayarSewa;
	}
	public function setUnitBayarSewa($unitBayarSewa) {
		$this->unitBayarSewa = $unitBayarSewa;
	}
	
	/**
	 * @Orm\Column(name="TERMIN_BAYAR_SEWA", type="string", length="100", nullable=true)
	 */
	private $terminBayarSewa;
	public function getTerminBayarSewa() {
		return $this->terminBayarSewa;
	}
	public function setTerminBayarSewa($terminBayarSewa) {
		$this->terminBayarSewa = $terminBayarSewa;
	}
	
	/**
	 * @Orm\Column(name="KET_PERUBAHAN", type="string", length="4000", nullable=true)
	 */
	private $keteranganPerubahan;
	public function getKeteranganPerubahan() {
		return $this->keteranganPerubahan;
	}
	public function setKeteranganPerubahan($keteranganPerubahan) {
		$this->keteranganPerubahan = $keteranganPerubahan;
	}
	
	/**
	 * @Orm\Column(name="ALASAN_PERUBAHAN", type="string", length="4000", nullable=true)
	 */
	private $alasanPerubahan;
	public function getAlasanPerubahan() {
		return $this->alasanPerubahan;
	}
	public function setAlasanPerubahan($alasanPerubahan) {
		$this->alasanPerubahan = $alasanPerubahan;
	}
	
	/**
	 * @Orm\Column(name="LAMPIRAN", type="string", length="200", nullable=true)
	 */
	private $lampiran;
	public function getLampiran() {
		return $this->lampiran;
	}
	public function setLampiran($lampiran) {
		$this->lampiran = $lampiran;
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