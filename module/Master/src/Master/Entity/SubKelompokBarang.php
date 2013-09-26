<?php
namespace Master\Entity;

use Doctrine\ORM\Mapping as Orm;
use Application\Entity\KelompokBarang;

/**
 * Entity sub kelompok barang.
 * 
 * @Orm\Entity
 * @Orm\Table(name="MS_SUBKELOMPOK_BARANG")
 * 
 * @author zakyalvan
 */
class SubKelompokBarang {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_BARANG")
	 */
	private $kodeBarang;
	public function getKodeBarang() {
		return $this->kodeBarang;
	}
	public function setKodeBarang($kodeBarang) {
		$this->kodeBarang = $kodeBarang;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Master\Entity\KelompokBarang", fetch="lazy")
	 * @Orm\JoinColumn(name="KODE_KELOMPOK", referencedColumnName="KODE_KELOMPOK")
	 * 
	 * @var KelompokBarang
	 */
	private $kelompok;
	public function getKelompok() {
		return $this->kelompok;
	}
	public function setKelompok(KelompokBarang $kelompok) {
		$this->kelompok = $kelompok;
	} 
	
	/**
	 * @Column(name="KODE_SUBKELOMPOK", type="string")
	 */
	private $kodeSubKelompok;
	public function getKodeSubKelompok() {
		return $this->kodeSubKelompok;
	}
	public function setKodeSubKelompok($kodeSubKelompok) {
		$this->kodeSubKelompok = $kodeSubKelompok;
	}
	
	/**
	 * @Column(name="NAMA_SUBKELOMPOK", type="string")
	 */
	private $namaSubKelompok;
	public function getNamaSubKelompok() {
		return $this->namaSubKelompok;
	}
	public function setNamaSubKelompok($namaSubKelompok) {
		$this->namaSubKelompok = $namaSubKelompok;
	} 
	
	/**
	 * @Column(name="AKTIF", type="string", nullable=true)
	 */
	private $aktif;
	public function getAktif() {
		return $this->aktif;
	}
	public function setAktif($aktif) {
		$this->aktif = $aktif;
	}
}