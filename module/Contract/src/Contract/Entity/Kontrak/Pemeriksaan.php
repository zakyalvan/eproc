<?php
namespace Contract\Entity\Kontrak;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity pemeriksaan kontrak.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_KONTRAK_PEMERIKSAAN")
 * 
 * @author zakyalvan
 */
class Pemeriksaan {
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak", fetch="join")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", type="string", length="50", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", length="5", referencedColumnName="KODE_KONTRAK")})
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
	 * @Orm\Column(name="KODE_PARAM", type="string", length="50", nullable=false)
	 * 
	 * @var string
	 */
	private $kodeParameter;
	public function getKodeParameter() {
		return $this->kodeParameter;
	}
	public function setKodeParameter($kodeParameter) {
		$this->kodeParameter = $kodeParameter;
	}
	
	/**
	 * @Orm\Column(name="NAMA_PARAM", type="string", length="1024", nullable=false)
	 *
	 * @var string
	 */
	private $namaParameter;
	public function getNamaParameter() {
		return $this->namaParameter;
	}
	public function setNamaParameter($namaParameter) {
		$this->namaParameter = $namaParameter;
	}
	
	/**
	 * @Orm\Column(name="HASIL", type="integer", nullable=false)
	 *
	 * @var string
	 */
	private $hasil;
	public function getHasil() {
		return $this->hasil;
	}
	public function setHasil($hasil) {
		$this->hasil = $hasil;
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