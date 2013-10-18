<?php
namespace Contract\Entity\Kontrak;

use Doctrine\ORM\Mapping as Orm;
use Vendor\Entity\Vendor;
use Procurement\Entity\Tender\Tender;
use Application\Entity\MataUang;
use Application\Entity\Kantor;
use Doctrine\Common\Collections\ArrayCollection;
use Contract\Entity\Invoice\Dokumen;

/**
 * Entity header dari sebuah kontrak.
 * 
 * @Orm\Entity(repositoryClass="Contract\Entity\Kontrak\Repository\KontrakRepository")
 * @Orm\Table(name="EP_KTR_KONTRAK")
 * 
 * @author zakyalvan
 */
class Kontrak {
	const TIPE_LUMPSUM = 'LUMPSUM';
	const TIPE_HARGA_SATUAN = 'HARGA SATUAN';
	const TIPE_RENTAL_SERVICE = 'RENTAL SERVICE';
	
	const JENIS_SPK = 'SPK';
	const JENIS_PERJANJIAN = 'PERJANJIAN';
	
	public function __construct() {
		$this->listItem = new ArrayCollection();
		$this->listMilestone = new ArrayCollection();
		$this->listDokumen = new ArrayCollection();
		$this->listKomentar = new ArrayCollection();
	}
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KONTRAK", type="string")
	 * @Orm\GeneratedValue(strategy="NONE")
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
	 * @Orm\Column(name="KODE_KANTOR", type="string")
	 * 
	 * @var unknown
	 */
	private $kodeKantor;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Kantor", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR")
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
	 * @Orm\ManyToOne(targetEntity="Procurement\Entity\Tender\Tender", fetch="LAZY", inversedBy="listKontrak")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_TENDER", referencedColumnName="KODE_TENDER"), @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR")})
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
	 * @Orm\Column(name="NO_KONTRAK", type="string", nullable=true)
	 */
	private $nomorKontrak;
	public function getNomorKontrak() {
		return $this->nomorKontrak;
	}
	public function setNomorKontrak($nomorKontrak) {
		$this->nomorKontrak = $nomorKontrak;
	}
	
	/**
	 * @Orm\Column(name="USER_PEMINTA", type="string", nullable=true)
	 */
	private $userPeminta;
	public function getUserPeminta() {
		return $this->userPeminta;
	}
	public function setUserPeminta($userPeminta) {
		$this->userPeminta = $userPeminta;
	}
	
	/**
	 * @Orm\Column(name="JABATAN_PEMINTA", type="string", nullable=true)
	 */
	private $jabatanPeminta;
	public function getJabatanPeminta() {
		return $this->jabatanPeminta;
	}
	public function setJabatanPeminta($jabatanPeminta) {
		$this->jabatanPeminta = $jabatanPeminta;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Vendor\Entity\Vendor", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_VENDOR", referencedColumnName="KODE_VENDOR")
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
	 * @Orm\Column(name="TGL_TTD", type="datetime", nullable=true)
	 */
	private $tanggalTandaTangan;
	public function getTanggalTandaTangan() {
		return $this->tanggalTandaTangan;
	}
	public function setTanggalTandaTangan($tanggalTandaTangan) {
		$this->tanggalTandaTangan = $tanggalTandaTangan;
	}
	
	/**
	 * @Orm\Column(name="TGL_MULAI", type="datetime", nullable=true)
	 */
	private $tanggalMulai;
	public function getTanggalMulai() {
		return $this->tanggalMulai;
	}
	public function setTanggalMulai($tanggalMulai) {
		$this->tanggalMulai = $tanggalMulai;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR", type="datetime", nullable=true)
	 */
	private $tanggalAkhir;
	public function getTanggalAkhir() {
		return $this->tanggalAkhir;
	}
	public function setTanggalAkhir($tanggalAkhir) {
		$this->tanggalAkhir = $tanggalAkhir;
	}
	
	/**
	 * @Orm\Column(name="TGL_BUAT", type="datetime", nullable=true)
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
	 * @Orm\ManyToOne(targetEntity="Master\Entity\MataUang", fetch="LAZY")
	 * @Orm\JoinColumn(name="MATA_UANG", referencedColumnName="MATA_UANG", nullable=true)
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
	 * @Orm\Column(name="NILAI_KONTRAK", type="bigint", nullable=true)
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
	 * @Orm\Column(name="TGL_PEMUTUSAN", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
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
	 * @Orm\Column(name="JUMLAH_PERUBAHAN", type="float", nullable=true)
	 */
	private $jumlahPerubahan;
	public function getJumlahPerubahan() {
		return $this->jumlahPerubahan;
	}
	public function setJumlahPerubahan($jumlahPerubahan) {
		$this->jumlahPerubahan = $jumlahPerubahan;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR_PENAWARAN", type="datetime", nullable=true)
	 */
	private $tanggalAkhirPenawaran;
	public function getTanggalAkhirPenawaran() {
		return $this->tanggalAkhirPenawaran;
	}
	public function setTanggalAlhirPenawaran($tanggalAkhirPenawaran) {
		$this->tanggalAkhirPenawaran = $tanggalAkhirPenawaran;
	}
	
	/**
	 * @Orm\OneToOne(targetEntity="Contract\Entity\Kontrak\JaminanPelaksanaan", fetch="EAGER", mappedBy="kontrak")
	 * 
	 * @var JaminanPelaksanaan
	 */
	private $jaminanPelaksanaan;
	public function getJaminanPelaksanaan() {
		return $this->jaminanPelaksanaan;
	}
	public function setJaminanPelaksanaan(JaminanPelaksanaan $jaminanPelaksanaan) {
		$this->jaminanPelaksanaan = $jaminanPelaksanaan;
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
	 * @Orm\Column(name="UM_NILAI", type="float", nullable=true)
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
		return $this->alasanPemutusan;
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
	private $lingkupPekerjaan;
	public function getLingkupPekerjaan() {
		return $this->lingkupPekerjaan;
	}
	public function setLingkupPekerjaan($lingkupPekerjaan) {
		$this->lingkupPekerjaan = $lingkupPekerjaan;
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
	 * @Orm\OneToMany(targetEntity="Contract\Entity\Kontrak\Item", fetch="LAZY", mappedBy="kontrak")
	 * 
	 * @var ArrayCollection
	 */
	private $listItem;
	public function getListItem() {
		if($this->listItem == null) {
			return new ArrayCollection();
		}
		return $this->listItem;
	}
	public function setListItem(ArrayCollection $listItem) {
		$this->listItem = $listItem;
	}
	public function addListItem($item) {
		$this->getListItem()->add($item);
	}
	public function removeListItem($item) {
		$this->getListItem()->remove($item);
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Contract\Entity\Kontrak\Milestone", fetch="LAZY", mappedBy="kontrak")
	 *
	 * @var ArrayCollection
	 */
	private $listMilestone;
	public function getListMilestone() {
		if($this->listMilestone == null) {
			return new ArrayCollection();
		}
		return $this->listMilestone;
	}
	public function setListMilestone(ArrayCollection $listMilestone) {
		$this->listMilestone = $listMilestone;
	}
	public function addListMilestone($milestone) {
		$this->getListMilestone()->add($milestone);
	}
	public function removeListMilestone($milestone) {
		$this->getListMilestone()->remove($milestone);
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Contract\Entity\Kontrak\Dokumen", fetch="LAZY", mappedBy="kontrak")
	 *
	 * @var ArrayCollection
	 */
	private $listDokumen;
	public function getListDokumen() {
		if($this->listDokumen == null) {
			return new ArrayCollection();
		}
		return $this->listDokumen;
	}
	public function setListDokumen(ArrayCollection $listDokumen) {
		$this->listDokumen = $listDokumen;
	}
	public function addListDokumen($dokumen) {
		$this->getListDokumen()->add($dokumen);
	}
	public function removeListDokumen($dokumen) {
		$this->getListDokumen()->remove($dokumen);
	}
	
	/**
	 * List dari komentar, disusun berdasarkan tanggal pembuatan kontrak.
	 * 
	 * @Orm\OneToMany(targetEntity="Contract\Entity\Kontrak\Komentar", fetch="LAZY", mappedBy="kontrak")
	 * @Orm\OrderBy({"tanggal" = "DESC"})
	 *
	 * @var ArrayCollection
	 */
	private $listKomentar;
	public function getListKomentar() {
		if($this->listKomentar == null) {
			return new ArrayCollection();
		}
		return $this->listKomentar;
	}
	public function setListKomentar(ArrayCollection $listKomentar) {
		$this->listKomentar = $listKomentar;
	}
	public function addListKomentar($komentar) {
		$this->getListKomentar()->add($komentar);
	}
	public function removeListKomentar($komentar) {
		$this->getListKomentar()->remove($komentar);
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
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
	 * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
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