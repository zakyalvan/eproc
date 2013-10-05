<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity yang menyimpan file-file yang diupload.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_FILE")
 * 
 * @author zakyalvan
 */
class UploadedFile {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="NAMA_FILE", type="string", length="255")
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
	 * @Orm\Column(name="PATH_FILE", type="string", length="1024", nullable=false)
	 * 
	 * @var string
	 */
	private $path;
	public function getPath() {
		return $this->path;
	}
	public function setPath($path) {
		$this->path = $path;
	}
	
	/**
	 * @Orm\Column(name="ALIAS_FILE", type="string", length="255", nullable=true)
	 * 
	 * @var string
	 */
	private $alias;
	public function getAlias() {
		return $this->alias;
	}
	public function setAlias($alias) {
		$this->alias = $alias;
	}
	
	/**
	 * @Orm\Column(name="MIME_FILE", type="string", length="255", nullable=true)
	 * 
	 * @var string
	 */
	private $jenisMime;
	public function getJenisMime() {
		return $this->jenisMime;
	}
	public function setJenisMime($jenisMime) {
		$this->jenisMime = $jenisMime;
	}
	
	/**
	 * @Orm\Column(name="TGL_BUAT", type="date", nullable=true)
	 * 
	 * @var date
	 */
	private $tanggalBuat;
	public function getTanggalBuat() {
		return $this->tanggalBuat;
	}
	public function setTanggalBuat($tanggalBuat) {
		$this->tanggalBuat = $tanggalBuat;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_BUAT", type="string", nullabe=true)
	 * 
	 * @var string
	 */
	private $petugasBuat;
	public function getPetugasBuat() {
		return $this->petugasBuat;
	}
	public function setPetugasBuat($petugasBuat) {
		$this->petugasBuat = $petugasBuat;
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
	 * @Orm\Column(name="PETUGAS_BUAT", type="string", nullabe=true)
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