<?php
namespace Contract\Entity\Po;

use Doctrine\ORM\Mapping as Orm;
use Vendor\Entity\Vendor;
use Contract\Entity\Kontrak\Kontrak;
use Application\Entity\MataUang;

/**
 * Entity header dari PO
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PO")
 * 
 * @author zakyalvan
 */
class Po {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_PO", type="string", length="50")
	 * @Orm\GeneratedValue(strategy="NONE")
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
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Kontrak", fetch="lazy")
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
	 * @Orm\Column(name="NAMA_LENGKAP_PEMBUAT", type="string", length="250", nullable=true)
	 *
	 * @var string
	 */
	private $namaLengkapPembuat;
	public function getNamaLengkapPembuat() {
		return $this->namaLengkapPembuat;
	}
	public function setNamaLengkapPembuat($namaLengkapPembuat) {
		$this->namaLengkapPembuat = $namaLengkapPembuat;
	}
	
	/**
	 * @Orm\Column(name="POSISI_PEMBUAT", type="string", length="50", nullable=true)
	 *
	 * @var string
	 */
	private $posisiPembuat;
	public function getPosisiPembuat() {
		return $this->posisiPembuat;
	}
	public function setPosisiPembuat($posisiPembuat) {
		$this->posisiPembuat = $posisiPembuat;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Vendor\Entity\Vendor", fetch="lazy")
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
	 * @Orm\Column(name="NAMA_VENDOR", type="string", length="255", nullable=true)
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
	 * @Orm\ManyToOne(targetEntity="Master\Entity\MataUang")
	 * @Orm\JoinColumn(name="MATA_UANG", type="string", length="3", nullable=true, referencedColumnName="MATA_UANG")
	 *
	 * @var MataUang
	 */
	private $mataUang;
	public function getMataUang() {
		return $this->mataUang;
	}
	public function setMataUang(MataUang $mataUang) {
		$this->mataUang = $mataUang;
	}
	
	/**
	 * @Orm\Column(name="TGL_MULAI", type="date", nullable=true)
	 * 
	 * @var date
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
	 *
	 * @var date
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
	 * @Orm\Column(name="CATATAN_PO", type="string", length="1024", nullable=true)
	 *
	 * @var string
	 */
	private $catatan;
	public function getCatatan() {
		return $this->catatan;
	}
	public function setCatatan($catatan) {
		$this->catatan = $catatan;
	}
	
	/**
	 * @Orm\Column(name="TGL_PERSETUJUAN", type="date", nullable=true)
	 *
	 * @var date
	 */
	private $tanggalPersetujuan;
	public function getTanggalPersetujuan() {
		return $this->tanggalPersetujuan;
	}
	public function setTanggalPersetujuan($tanggalPersetujuan) {
		$this->tanggalPersetujuan = $tanggalPersetujuan;
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
	 * @Orm\Column(name="TGL_PERSETUJUAN_BASTP", type="date", nullable="true")
	 * 
	 * @var date
	 */
	private $tanggalPersetujuanBastp;
	public function getTanggalPersetujuanBastp() {
		return $this->tanggalPersetujuanBastp;
	}
	public function setTanggalPersetujuabBastp($tanggalPersetujuanBastp) {
		$this->tanggalPersetujuanBastp = $tanggalPersetujuanBastp;
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