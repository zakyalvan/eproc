<?php
namespace Master\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="GL_MATA_UANG")
 * 
 * @author zakyalvan
 */
class MataUang {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="MATA_UANG", type="string")
	 */
	private $kode;
	public function getKode() {
		return $this->kode;
	}
	public function setKode($kode) {
		$this->kode = $kode;
	}
	
	/**
	 * @Orm\Column(name="NOTASI", type="string")
	 */
	private $notasi;
	public function getNotasi() {
		return $this->notasi;
	}
	public function setNotasi($notasi) {
		$this->notasi = $notasi;
	}
	
	/**
	 * @Orm\Column(name="STATUS_DEFAULT", type="string")
	 */
	private $statusDefault;
	public function getStatusDefault() {
		return $this->statusDefault;
	}
	public function setStatusDefault($statusDefault) {
		$this->statusDefault = $statusDefault;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN", type="string", nullable=true)
	 */
	private $keterangan;
	public function getKeterangan() {
		return $this->keterangan;
	}
	public function setKeterangan($keterangan) {
		$this->keterangan = $keterangan;
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
}