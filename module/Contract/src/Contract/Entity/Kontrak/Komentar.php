<?php
namespace Contract\Entity\Kontrak;

use Doctrine\ORM\Mapping as Orm;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Entity komentar kontrak.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_KONTRAK_KOMENTAR")
 * @Orm\HasLifecycleCallbacks
 * 
 * @author zakyalvan
 */
class Komentar {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KONTRAK", nullable=false)
	 * @Orm\GeneratedValue(strategy="NONE")
	 * 
	 * @var string
	 */
	private $kodeKontrak;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KANTOR", nullable=false)
	 * @Orm\GeneratedValue(strategy="NONE")
	 * 
	 * @var string
	 */
	private $kodeKantor;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KOMENTAR", type="integer")
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
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Kontrak", fetch="LAZY", inversedBy="listKomentar")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KONTRAK", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR")})
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
	 * @Orm\Column(name="KODE_JABATAN", type="integer", nullable=true)
	 * 
	 * @var integer
	 */
	private $kodeJabatan;
	public function getKodeJabatan() {
		return $this->kodeJabatan;
	}
	public function setKodeJabatan($kodeJabatan) {
		$this->kodeJabatan = $kodeJabatan;
	}
	
	/**
	 * @Orm\Column(name="NAMA_JABATAN", type="string", length=150, nullable=true)
	 * 
	 * @var string
	 */
	private $namaJabatan;
	public function getNamaJabatan() {
		return $this->namaJabatan;
	}
	public function setNamaJabatan($namaJabatan) {
		$this->namaJabatan = $namaJabatan;
	}
	
	/**
	 * @Orm\Column(name="NAMA_KOMENTAR", type="string", length=50, nullable=true)
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
	 * @Orm\Column(name="TGL_KOMENTAR", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	private $tanggal;
	public function getTanggal() {
		return $this->tanggal;
	}
	public function setTanggal($tanggal) {
		$this->tanggal = $tanggal;
	}
	
	/**
	 * @Orm\Column(name="STATUS_KOMENTAR", type="string", length=5, nullable=true)
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
	 * @Orm\Column(name="TANGGAPAN_KOMENTAR", type="string", length=100, nullable=true)
	 * 
	 * @var string
	 */
	private $tanggapan;
	public function getTanggapan() {
		return $this->tanggapan;
	}
	public function setTanggapan($tanggapan) {
		$this->tanggapan = $tanggapan;
	}
	
	/**
	 * @Orm\Column(name="LAMPIRAN", type="string", length=256, nullable=true)
	 * 
	 * @var string
	 */
	private $lampiran;
	public function getLampiran() {
		return $this->lampiran;
	}
	public function setLampiran($lampiran) {
		$this->lampiran = $lampiran;
	}
	
	/**
	 * @Orm\Column(name="KOMENTAR", type="string", length=4000, nullable=true)
	 * 
	 * @var string
	 */
	private $isi;
	public function getIsi() {
		return $this->isi;
	}
	public function setIsi($isi) {
		$this->isi = $isi;
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
	 * @Orm\Column(name="PETUGAS_REKAM", type="string", length=10, nullable=true)
	 * 
	 * @var string
	 */
	private $petugasRekam;
	public function getPetugasRekam() {
		return $this->petugasRekam;
	}
	public function setPetugasRekam($petugasRekam) {
		$this->petugasRekam = $petugasRekam;
	}
	
	
	/**
	 * @Orm\Column(name="TGL_UBAH", type="date", length=10, nullable=true)
	 *
	 * @var string
	 */
	private $tanggalUbah;
	public function getTanggalUbah() {
		return $this->tanggalUbah;
	}
	public function setTanggalUbah($tanggalUbah) {
		$this->tanggalUbah = $tanggalUbah;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_UBAH", type="string", length=10, nullable=true)
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
	
	/**
	 * @Orm\PrePersist
	 */
	public function prePersist(LifecycleEventArgs $event) {
		if($this->kontrak !== null) {
			$this->kodeKantor = $this->kontrak->getKantor()->getKode();
			$this->kodeKontrak = $this->kontrak->getKode();
			$this->setTanggalRekam(new \DateTime());
		}
	}
	
	/**
	 * @Orm\PreUpdate
	 */
	public function preUpdate(PreUpdateEventArgs $event) {
		$this->tanggalUbah = new \DateTime();
	}
}