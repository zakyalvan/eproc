<?php
namespace Contract\Entity\Po;

use Doctrine\ORM\Mapping as Orm;
use Vendor\Entity\Vendor;
use Contract\Entity\Kontrak\Kontrak;
use Application\Entity\MataUang;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entity header dari PO
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PO")
 * 
 * @author zakyalvan
 */
class Po {
	public function __construct() {
		$this->listItem = new ArrayCollection();
		$this->listProgress = new ArrayCollection();
		$this->listKomentar = new ArrayCollection();
	}
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_PO", type="string", length=50)
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
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Kontrak", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", referencedColumnName="KODE_KONTRAK")})
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
	 * @Orm\Column(name="NAMA_PEMBUAT", type="string", length=250, nullable=true)
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
	 * @Orm\Column(name="NAMA_LENGKAP_PEMBUAT", type="string", length=250, nullable=true)
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
	 * @Orm\Column(name="POSISI_PEMBUAT", type="string", length=50, nullable=true)
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
	 * @Orm\ManyToOne(targetEntity="Vendor\Entity\Vendor", fetch="LAZY")
	 * @JoinColumn(name="KODE_VENDOR", referencedColumnName="KODE_VENDOR")
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
	 * @Orm\Column(name="NAMA_VENDOR", type="string", length=255, nullable=true)
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
	 * @Orm\JoinColumn(name="MATA_UANG", nullable=true, referencedColumnName="MATA_UANG")
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
	 * @Orm\Column(name="TGL_MULAI", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	private $tanggalMulai;
	public function getTanggalMulai() {
		return $this->tanggalMulai;
	}
	public function setTanggalMulai(\DateTime $tanggalMulai) {
		$this->tanggalMulai = $tanggalMulai;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalAkhir;
	public function getTanggalAkhir() {
		return $this->tanggalAkhir;
	}
	public function setTanggalAkhir(\DateTime $tanggalAkhir) {
		$this->tanggalAkhir = $tanggalAkhir;
	}
	
	/**
	 * @Orm\Column(name="TGL_BUAT", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalPembuatan;
	public function getTanggalPembuatan() {
		return $this->tanggalPembuatan;
	}
	public function setTanggalPembuatan(\DateTime $tanggalPembuatan) {
		$this->tanggalPembuatan = $tanggalPembuatan;
	}
	
	/**
	 * @Orm\Column(name="CATATAN_PO", type="string", length=1024, nullable=true)
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
	 * @Orm\Column(name="TGL_PERSETUJUAN", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalPersetujuan;
	public function getTanggalPersetujuan() {
		return $this->tanggalPersetujuan;
	}
	public function setTanggalPersetujuan(\DateTime $tanggalPersetujuan) {
		$this->tanggalPersetujuan = $tanggalPersetujuan;
	}
	
	/**
	 * @Orm\Column(name="STATUS", type="string", length=2, nullable=true)
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
	 * @Orm\Column(name="NO_BASTP", type="string", length=50, nullable=true)
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
	 * @Orm\Column(name="TGL_BASTP", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalBastp;
	public function getTanggalBastp() {
		return $this->tanggalBastp;
	}
	public function setTanggalBastp($tanggalBastp) {
		$this->tanggalBastp = $tanggalBastp;
	}
	
	/**
	 * @Orm\Column(name="JUDUL_BASTP", type="string", length=1024, nullable=true)
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
	 * @Orm\Column(name="LAMPIRAN_BASTP", type="string", length=250, nullable=true)
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
	 * @Orm\Column(name="TGL_BUAT_BASTP", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalPembuatanBastp;
	public function getTanggalPembuatanBastp() {
		return $this->tanggalPembuatanBastp;
	}
	public function setTanggalPembuatanBastp(\DateTime $tanggalPembuatanBastp) {
		$this->tanggalPembuatanBastp = $tanggalPembuatanBastp;
	}
	
	/**
	 * @Orm\Column(name="STATUS_BASTP", type="string", length=2, nullable=true)
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
	 * @Orm\Column(name="TGL_PERSETUJUAN_BASTP", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	private $tanggalPersetujuanBastp;
	public function getTanggalPersetujuanBastp() {
		return $this->tanggalPersetujuanBastp;
	}
	public function setTanggalPersetujuabBastp(\DateTime $tanggalPersetujuanBastp) {
		$this->tanggalPersetujuanBastp = $tanggalPersetujuanBastp;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN_BASTP", type="string", length=4000, nullable=true)
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
	 * @Orm\OneToMany(targetEntity="Contract\Entity\Po\Item", fetch="LAZY", mappedBy="po")
	 * 
	 * @var ArrayCollection
	 */
	private $listItem;
	public function getListItem() {
		return $this->listItem;
	}
	public function setListItem(ArrayCollection $listItem) {
		$this->listItem = $listItem;
	}
	public function addListItem(ArrayCollection $listItem) {
		foreach ($listItem as $item) {
			$this->listItem->add($item);
		}
	}
	public function removeListItem(ArrayCollection $listItem) {
		foreach ($listItem as $item) {
			$this->listItem->removeElement($item);
		}
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Contract\Entity\Po\Progress", fetch="LAZY", mappedBy="po")
	 * 
	 * @var ArrayCollection
	 */
	private $listProgress;
	public function getListProgress() {
		return $listProgress;
	}
	public function setListProgress(ArrayCollection $listProgress) {
		$this->listProgress = $listProgress;
	}
	public function addListPerkembangan(ArrayCollection $listProgress) {
		foreach ($listProgress as $progress) {
			$this->listProgress->add($progress);
		}
	}
	public function removeListPerkembangan(ArrayCollection $listProgress) {
		foreach ($listProgress as $progress) {
			if($this->listProgress->contains($progress)) {
				$this->listProgress->remove($this->listProgress->indexOf($progress));
			}
		}
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Contract\Entity\Po\Komentar", fetch="LAZY", inversedBy="po")
	 * 
	 * @var ArrayCollection
	 */
	private $listKomentar;
	public function getListKomentar() {
		return $this->listKomentar;
	}
	public function setListKomentar(ArrayCollection $listKomentar) {
		$this->listKomentar = $listKomentar;
	}
	public function addListKomentar(ArrayCollection $listKomentar) {
		foreach ($listKomentar as $komentar) {
			$this->listKomentar->add($komentar);
		}
	}
	public function removeListKomentar(ArrayCollection $listKomentar) {
		foreach ($listKomentar as $komentar) {
			$this->listKomentar->removeElement($komentar);
		}
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalRekam;
	public function getTanggalRekam() {
		return $this->tanggalRekam;
	}
	public function setTanggalRekam(\DateTime $tanggalRekam) {
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
	 * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
	 *
	 * @var \DateTime
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