<?php
namespace Vendor\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_VENDOR")
 * 
 * @author zakyalvan
 */
class Vendor {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_VENDOR", type="integer")
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
	 * @Orm\Column(name="NAMA_VENDOR", type="string", length=50, nullable=true)
	 * 
	 * @var string
	 */
	private $nama;
	public function getNama() {
		return $this->nama;
	}
	public function setNama($nama) {
		$this->nama = $nama;
	}
	
	/**
	 * @Orm\Column(name="KODE_LOGIN", type="string", length=50, nullable=true)
	 */
	private $kodeLogin;
	public function getKodeLogin() {
		return $this->kodeLogin;
	}
	public function setKodeLogin($kodeLogin) {
		$this->kodeLogin = $kodeLogin;
	}
	
	/**
	 * @Orm\Column(name="PASSWRD", type="string", length=255, nullable=true)
	 */
	private $password;
	public function getPassword() {
		return $this->password;
	}
	public function setPassword($password) {
		$this->password = $password;
	}
	
	/**
	 * @Orm\Column(name="ALAMAT_EMAIL", type="string", length=255, nullable=true)
	 */
	private $alamatEmail;
	public function getAlamatEmail() {
		return $this->alamatEmail;
	}
	public function setAlamatEmail($alamatEmail) {
		$this->alamatEmail = $alamatEmail;
	}
	
	/**
	 * @Orm\Column(name="AWALAN", type="string", length=50, nullable=true)
	 */
	private $awalan;
	public function getAwalan() {
		return $this->awalan;
	}
	public function setAwalan($awalan) {
		$this->awalan = $awalan;
	}
	
	/**
	 * @Orm\Column(name="AWALAN_LAIN", type="string", length=50, nullable=true)
	 */
	private $awalanLain;
	public function getAwalanLain() {
		return $this->awalanLain;
	}
	public function setAwalanLain($awalanLain) {
		$this->awalanLain = $awalanLain;
	}
	
	/**
	 * @Orm\Column(name="AKHIRAN", type="string", length=50, nullable=true)
	 * 
	 * @var string
	 */
	private $akhiran;
	public function getAkhiran() {
		return $this->akhiran;
	}
	public function setAkhiran($akhiran) {
		$this->akhiran = $akhiran;
	}
	
	/**
	 * @Orm\Column(name="AKHIRAN_LAIN", type="string", length=50, nullable=true)
	 * 
	 * @var string
	 */
	private $akhiranLain;
	public function getAkhiranLain() {
		return $this->akhiranLain;
	}
	public function setAkhiranLain($akhiranLain) {
		$this->akhiranLain = $akhiranLain;
	}
	
	/**
	 * @Orm\Column(name="ALAMAT", type="string", length=512, nullable=true)
	 * 
	 * @var string
	 */
	private $alamat;
	public function getAlamat() {
		return $this->alamat;
	}
	public function setAlamat($alamat) {
		$this->alamat = $alamat;
	}
	
	/**
	 * @Orm\Column(name="KOTA", type="string", length=512, nullable=true)
	 * 
	 * @var string
	 */
	private $kota;
	public function getKota() {
		return $this->kota;
	}
	public function setKota($kota) {
		$this->kota = $kota;
	}
	
	/**
	 * @Orm\Column(name="PROPINSI", type="string", nullable=true)
	 */
	private $propinsi;
	public function getPropinsi() {
		return $this->propinsi;
	}
	public function setPropinsi($propinsi) {
		$this->propinsi = $propinsi;
	}
	
	/**
	 * @Orm\Column(name="KODE_POS", type="string", nullable=true)
	 */
	private $kodePos;
	public function getKodePos() {
		return $this->getKodePos();
	}
	public function setKodePos($kodePos) {
		$this->kodePos = $kodePos;
	}
	
	/**
	 * @Orm\Column(name="NEGARA", type="string", nullable=true)
	 */
	private $negara;
	public function getNegara() {
		return $this->negara;
	}
	public function setNegara($negara) {
		$this->negara = $negara;
	}
	
	/**
	 * @Orm\Column(name="NO_TELP", type="string", nullable=true)
	 */
	private $nomorTelepon;
	public function getNomorTelepon() {
		return $this->nomorTelepon;
	}
	public function setNomorTelepon($nomorTelapon) {
		$this->nomorTelepon = $nomorTelapon;
	}
	
	/**
	 * @Orm\Column(name="WEBSITE", type="string", nullable=true)
	 */
	private $website;
	public function getWebsite() {
		return $this->website;
	}
	public function setWebsite($website) {
		$this->website = $website;
	}
	
	/**
	 * @Orm\Column(name="NO_DOMISILI", nullable=true)
	 */
	private $nomorDomisili;
	public function getNomorDomisili() {
		return $this->nomorDomisili;
	}
	public function setNomorDomisili($nomorDomisili) {
		$this->nomorDomisili = $nomorDomisili;
	}
	
	/**
	 * @Orm\Column(name="TGL_DOMISILI", type="date", nullable=true)
	 */
	private $tanggalDomisili;
	public function getTanggalDomisili() {
		return $this->tanggalDomisili;
	}
	public function setTanggalDomisli($tanggalDomisili) {
		$this->tanggalDomisili = $tanggalDomisili;
	}
	
	/**
	 * @Orm\Column(name="KADALUARSA_DOMISILI", type="date", nullable=true)
	 */
	private $kadaluarsaDomisili;
	public function getKadaluarsaDomisili() {
		return $this->kadaluarsaDomisili;
	}
	public function setKadaluarsaDomisili($kadaluarsaDomisili) {
		$this->kadaluarsaDomisili = $kadaluarsaDomisili;
	} 
	
	/**
	 * @Orm\Column(name="NAMA_KONTAK", nullable=true)
	 */
	private $namaKontak;
	public function getNamaKontak() {
		return $this->namaKontak;
	}
	public function setNamaKontak($namaKontak) {
		$this->namaKontak = $namaKontak;
	}
	
	
	/**
	 * @Orm\Column(name="JABATAN_KONTAK", type="string", nullable=true)
	 */
	private $jabatanKontak;
	public function getJabatanKontak() {
		return $this->jabatanKontak;
	}
	public function setJabatanKontak($jabatanKontak) {
		$this->jabatanKontak = $jabatanKontak;
	}
	
	/**
	 * @Orm\Column(name="NO_TELP_KONTAK", nullable=true)
	 */
	private $nomorTeleponKontak;
	public function getNomorTeleponKontak() {
		return $this->nomorTeleponKontak;
	}
	public function setNomorTeleponKontak($nomorTeleponKontak) {
		$this->nomorTeleponKontak = $nomorTeleponKontak;
	}
	
	/**
	 * @Orm\Column(name="EMAIL_KONTAK", nullable=true)
	 */
	private $emailKontak;
	public function getEmailKontak() {
		return $this->emailKontak;
	}
	public function setEmailKontak($emailKontak) {
		$this->emailKontak = $emailKontak;
	}
	
	/**
	 * @Orm\Column(name="NPP", nullable=true)
	 */
	private $npp;
	public function getNpp() {
		return $this->npp;
	}
	public function setNpp($npp) {
		$this->npp = $npp;
	}
	
	/**
	 * @Orm\Column(name="TGL_NPP", type="date", nullable=true)
	 */
	private $tanggalNpp;
	public function getTanggalNpp() {
		return $this->tanggalNpp;
	}
	public function setTanggalNpp($tanggalNpp) {
		$this->tanggalNpp = $tanggalNpp;
	}
	
	/**
	 * @Orm\Column(name="NO_NPWP", nullable=true)
	 */
	private $nomorNpwp;
	public function getNomorNpwp() {
		return $this->nomorNpwp;
	}
	public function setNomorNpwp($nomorNpwp) {
		$this->nomorNpwp = $nomorNpwp;
	}
	
	/**
	 * @Orm\Column(name="ALAMAT_NPWP", nullable=true)
	 */
	private $alamatNpwp;
	public function getAlamatNpwp() {
		return $this->alamatNpwp;
	}
	public function setAlamatNpwp($alamatNpwp) {
		$this->alamatNpwp = $alamatNpwp;
	}
	
	/**
	 * @Orm\Column(name="KOTA_NPWP", nullable=true)
	 */
	private $kotaNpwp;
	public function getKotaNpwp() {
		return $this->kotaNpwp;
	}
	public function setKotaNpwp($kotaNpwp) {
		$this->kotaNpwp = $kotaNpwp;
	}
	
	/**
	 * @Orm\Column(name="PROPINSI_NPWP", nullable=true)
	 */
	private $propinsiNpwp;
	public function getPropinsiNpwp() {
		return $this->propinsiNpwp;
	}
	
	/**
	 * @Orm\Column(name="KODE_POS_NPWP", nullable=true)
	 */
	private $kodePosNpwp;
	public function getKodePosNpwp() {
		return $this->kodePosNpwp;
	}
	public function setKodePosNpwp($kodePosNpwp) {
		$this->kodePosNpwp = $kodePosNpwp;
	}
	
	/**
	 * @Orm\Column(name="PKP_NPWP", nullable=true)
	 */
	private $pkpNpwp;
	public function getPkpNpwp() {
		return $this->pkpNpwp;
	}
	public function setPkpNpwp($pkpNpwp) {
		$this->pkpNpwp = $pkpNpwp;
	}
	
	/**
	 * @Orm\Column(name="NO_PKP_NPWP", nullable=true)
	 */
	private $nomorPkpNpwp;
	public function getNomorPkpNpwp() {
		return $this->nomorPkpNpwp;
	}
	public function setNomorPkpNpwp($nomorPkpNpwp) {
		$this->nomorPkpNpwp = $nomorPkpNpwp;
	}
	
	/**
	 * @Orm\Column(name="TIPE_VENDOR", nullable=true)
	 */
	private $tipeVendor;
	public function getTipeVendor() {
		return $this->tipeVendor;
	}
	public function setTipeVendor($tipeVendor) {
		$this->tipeVendor = $tipeVendor;
	}
	
	/**
	 * @Orm\Column(name="TIPE_SIUP_IUJK", nullable=true)
	 */
	private $tipeSiupIujk;
	public function getTipeSiupIujk() {
		return $this->tipeSiupIujk;
	}
	public function setTipeSiupIujk($tipeSiupIujk) {
		$this->tipeSiupIujk = $tipeSiupIujk;
	}
	
	/**
	 * @Orm\Column(name="SIUP_DITERBITKAN_OLEH", nullable=true)
	 */
	private $siupDiterbitkanOleh;
	public function getSiupDiterbitkanOleh() {
		return $this->siupDiterbitkanOleh;
	}
	public function setSiupDiterbitkanOleh($siupDiterbitkanOleh) {
		$this->siupDiterbitkanOleh = $siupDiterbitkanOleh;
	}
	
	/**
	 * @Orm\Column(name="NO_SIUP", nullable=true)
	 */
	private $nomorSiup;
	public function getNomorSiup() {
		return $this->nomorSiup;
	}
	public function setNomorSiup($nomorSiup) {
		$this->nomorSiup = $nomorSiup;
	}
	
	/**
	 * @Orm\Column(name="TIPE_SIUP", nullable=true)
	 */
	private $tipeSiup;
	public function getTipeSiup() {
		return $this->tipeSiup;
	}
	public function setTipeSiup($tipeSiup) {
		$this->tipeSiup = $tipeSiup;
	}
	
	/**
	 * @Orm\Column(name="DARI_TGL_SIUP", type="date", nullable=true)
	 */
	private $dariTanggalSiup;
	/**
	 * @Orm\Column(name="SAMPAI_TGL_SIUP", type="date", nullable=true)
	 */
	private $sampaiTanggalSiup;
	
	/**
	 * @Orm\Column(name="TDP_ISSUED_BY", type="string", nullable=true)
	 */
	private $tdpDiterbitkanOleh;
	
	/**
	 * @Orm\Column(name="NO_TDP", type="string", nullable=true)
	 */
	private $nomorTdp;
	
	/**
	 * @Orm\Column(name="DARI_TGL_TDP", type="date", nullable=true)
	 */
	private $dariTglTdp;
	
	/**
	 * @Orm\Column(name="SAMPAI_TGL_TDP", type="date", nullable=true)
	 */
	private $sampaiTglTdp;
	
	/**
	 * @Orm\Column(name="AGEN_PENERBIT", type="string", nullable=true)
	 */
	private $agenPenerbit;
	
	/**
	 * @Orm\Column(name="DARI_AGEN", type="date", nullable=true)
	 */
	private $dariAgen;
	
	/**
	 * @Orm\Column(name="HINGGA_AGEN", type="date", nullable=true)
	 */
	private $hinggaAgen;
	
	/**
	 * @Orm\Column(name="PENERBIT_IMP", type="string", nullable=true)
	 */
	private $penerbitImp;
	
	/**
	 * @Orm\Column(name="DARI_IMP", type="date", nullable=true)
	 */
	private $dariImp;
	
	/**
	 * @Orm\Column(name="KE_IMP", type="date", nullable=true)
	 */
	private $keImp;
	private $attOrg;
	private $mataUangModalDasar;
	private $modalDasar;
	private $mataUangModalSetor;
	private $modalSetor;
	private $mataUangAssetdasar;
	private $assetDasar;
	private $mataUangLaporanKeu;
	private $tahunLaporanKeu;
	private $typeLaporanKeu;
	private $assetLaporanKeu;
	private $hutangLaporanKeu;
	private $pendapatanLaporanKeu;
	private $labaLaporanKeu;
	private $golonganKeuangan;
	private $berakhirDari;
	private $berakhirSampai;
	private $diakhiriOleh;
	private $status;
	private $halamanSelanjutnya;
	private $kodeStatusReg;
	private $statusReg;
	private $sessionIdReg;
	/**
	 * @Orm\Column(name="NO_VENDOR", type="string", nullable=true)
	 */
	private $nomorVendor;
	public function getNomorVendor() {
		return $this->nomorVendor;
	}
	public function setNomorVendor($nomorVendor) {
		$this->nomorVendor = $nomorVendor;
	}
	
	/**
	 * @Orm\Column(name="KODE_VENDOR_HU", type="integer", nullable=true)
	 */
	private $kodeVendorHu;
	public function getKodeVendorHu() {
		return $this->kodeVendorHu;
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
	 * @Orm\Column(name="PETUGAS_REKAM", type="string", length=50, nullable=true)
	 */
	private $petugasRekam;
	public function getPetugasRekam() {
		return $this->petugasRekam;
	}
	public function setPetugasRekam($petugasRekam) {
		$this->petugasRekam = $petugasRekam;
	}
	
	/**
	 * @Orm\Column(name="TGL_UBAH", nullable=true, type="date", nullable=true)
	 */
	private $tanggalUbah;
	public function getTanggalUbah() {
		return $this->tanggalUbah;
	}
	public function setTanggalUbah($tanggalUbah) {
		$this->tanggalUbah = $tanggalUbah;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_UBAH", type="string", length=50, nullable=true)
	 */
	private $petugasUbah;
	public function getPetugasUbah() {
		return $this->petugasUbah;
	}
	public function setPetugasUbah($petugasUbah) {
		$this->petugasUbah = $petugasUbah;
	}
}