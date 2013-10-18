<?php
namespace Contract\Entity\Kontrak;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_JANGKA_PERKEMBANGAN")
 *
 * @author zakyalvan
 */
class ProgressMilestone {
	/**
	 * Kode jangka perkembangan
	 * 
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
	 * @Orm\Column(name="KODE_JANGKA", type="integer")
	 * 
	 * @var integer
	 */
	private $kodeMilestone;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KONTRAK", type="string")
	 *
	 * @var string
	 */
	private $kodeKontrak;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KANTOR", type="string")
	 *
	 * @var string
	 */
	private $kodeKantor;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Milestone", fetch="LAZY", inversedBy="listProgress")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_JANGKA", referencedColumnName="KODE_JANGKA")})
	 * 
	 * @var Milestone
	 */
	private $milestone;
	public function getMilestone() {
		return $this->milestone;
	}
	public function setMilestone(Milestone $milestone) {
		$this->milestone = $milestone;
	}
	
	/**
	 * @Orm\Column(name="TGL_PERKEMBANGAN", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	private $tanggalPerkembangan;
	public function getTanggalPerkembangan() {
		return $this->tanggalPerkembangan;
	}
	public function setTanggalPerkembangan($tanggalPerkembangan) {
		$this->tanggalPerkembangan = $tanggalPerkembangan;
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
	 * @Orm\Column(name="KETERANGAN", type="string", length=4000, nullable=true)
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
	 * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
	 *
	 * @var \DateTime
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