<?php
namespace Contract\Entity;

use Doctrine\ORM\Mapping as Orm;
use Procurement\Entity\Tender\Tender;
use Contract\Entity\Kontrak\Kontrak;
use Application\Entity\User;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PENUNJUKAN_PENGELOLA")
 * 
 * @author zakyalvan
 */
class PenunjukanPengelola {
	const STATUS_PENUNJUKAN = 'PENUNJUKAN';
	const STATUS_PERGANTIAN = 'PERGANTIAN';
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_PENUNJUKAN", type="integer")
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
	 * @Orm\OneToOne(targetEntity="Procurement\Entity\Tender\Tender", fetch="LAZY")
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
	 * @Orm\OneToOne(targetEntity="Contract\Entity\Kontrak\Kontrak", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KONTRAK", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR", nullable=true)})
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
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_USER_PENGELOLA", referencedColumnName="KODE_USER")
	 * 
	 * @var User
	 */
	private $userPengelola;
	public function getUserPengelola() {
		return $this->userPengelola;
	}
	public function setUserPengelola($userPengelola) {
		$this->userPengelola = $userPengelola;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_USER_PENUNJUK", referencedColumnName="KODE_USER")
	 *
	 * @var User
	 */
	private $userPenunjuk;
	public function getUserPenunjuk() {
		return $this->userPenunjuk;
	}
	public function setUserPenunjuk($userPenunjuk) {
		$this->userPenunjuk = $userPenunjuk;
	}
	
	/**
	 * @Orm\Column(name="STATUS_PENUNJUKAN", type="integer", nullable=true)
	 */
	private $status;
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * @Orm\Column(name="KOMENTAR_PENUNJUKAN", type="string", length=1024, nullable=true)
	 */
	private $komentar;
	public function getKomentar() {
		return $this->komentar;
	}
	public function setKomentar($komentar) {
		$this->komentar = $komentar;
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