<?php
namespace Master\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity yang mewakili kelas barang.
 * 
 * @Orm\Entity
 * @Orm\Table(name="MS_KELOMPOK_BARANG")
 * 
 * @author zakyalvan
 */
class KelompokBarang {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KELOMPOK", type="string")
	 */
	private $kodeKelompok;
	public function getKodeKelompok() {
		return $this->kodeKelompok;
	}
	public function setKodeKelompok($kodeKelompok) {
		$this->kodeKelompok = $kodeKelompok;
	}
	
	/**
	 * @Orm\Column(name="NAMA_KELOMPOK", type="string", nullable=true)
	 */
	private $namaKelompok;
	public function getNamaKelompok() {
		return $this->namaKelompok;
	}
	public function setNamaKelompok($namaKelompok) {
		$this->namaKelompok = $namaKelompok;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Master\Entity\KelompokBarang", fetch="lazy", inversedBy="kelompokAnak")
	 * @Orm\JoinColumn(name="KODE_KELOMPOK_INDUK", type="string", referencedColumnName="KODE_KELOMPOK")
	 * 
	 * @var KelompokBarang
	 */
	private $kelompokIduk;
	public function getKelompokInduk() {
		return $this->kelompokIduk;
	}
	public function setKelompokInduk(KelompokBarang $kelompokInduk) {
		$this->kelompokIduk = $kelompokInduk;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Master\Entity\KelompokBarang", fetch="lazy", mappedBy="kelompokInduk")
	 */
	private $kelompokAnak;
	public function getKelompokAnak() {
		return $this->kelompokAnak;
	}
	public function setKelompokAnak($kelompokAnak) {
		$this->kelompokAnak = $kelompokAnak;
	}
	
	/**
	 * @Orm\Column(name="AKTIF", type="string", nullable=true)
	 */
	private $aktif;
	public function getAktif() {
		return $this->aktif;
	}
	public function setAktif($aktif) {
		$this->aktif = $aktif;
	}
}