<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entity yang nyimpan user fungsi, dari sipt.
 * 
 * @Orm\Entity
 * @Orm\Table(name="SC.SC_FUNGSI")
 * 
 * @author zakyalvan
 */
class Role {
	const KODE_PENATA_ALOKASI_DANA = '338';
	const KODE_PETUGAS_AKTIVA_TETAP = '339';
	const KODE_ENTRY_KBI = '340';
	const KODE_KEPATUHAN_DAN_HUKUM = '341';
	const KODE_PENATA_PELAKSANA_LELANG = '342';
	const KODE_PENATA_PELAKSANA_NON_LELANG = '343';
	const KODE_KAUR_PELAKSANA_NON_LELANG = '344';
	const KODE_KAUR_PERENCANAAN = '345';
	const KODE_KABIRO_PENGADAAN = '346';
	const KODE_PETUGAS_MEMO_PENCAIRAN_ANGGARAN = '347';
	
	const KODE_PENGGUNA_BARANG_DAN_JASA = '401';
	const KODE_APPROVAL_PENGGUNA_BARANG_DAN_JASA = '402';
	const KODE_PANITIA_LELANG_ATAU_PEMILIHAN = '403';
	const KODE_PELAKSANA_PENGADAAN = '404';
	const KODE_APPROVAL_PELAKSANA_PENGADAAN = '405';
	const KODE_APPROVAL_PENGADAAN = '406';
	const KODE_PENGELOLA_VENDOR = '407';
	const KODE_PELAKSANA_KONTRAK = '408';
	const KODE_APPROVAL_PERENCANAAN_PENGADAAN = '409';
	const KODE_APPROVAL_KONTRAK_DAN_VENDOR = '410';
	const KODE_PERENCANAAN_PENGADAAN = '411';
	const KODE_KEPALA_BAGIAN_MANAJEMEN_DAN_RISIKO = '412';
	
	/**
	 * Kode fungsi/role.
	 * 
	 * @Orm\Id
	 * @Orm\Column(name="KODE_FUNGSI", type="string")
	 * @Orm\GeneratedValue(strategy="NONE")
	 * 
	 * @var string
	 */
	protected $kode;
	public function getKode() {
		return $this->kode;
	}
	
	/**
	 * Nama fungsi/role.
	 * 
	 * @Orm\Column(name="NAMA_FUNGSI", type="string")
	 */
	protected $nama;
	public function getNama() {
		return $this->nama;
	}
	
	/**
	 * Inisial atau akronim untuk fungsi/role.
	 * 
	 * @Orm\Column(name="INISIAL_FUNGSI", type="string")
	 */
	protected $inisial;
	public function getInisial() {
		return $this->inisial;
	}
	
	/**
	 * Status aktif atau tidak.
	 * 
	 * @Orm\Column(name="AKTIF", type="string", nullable=true)
	 */
	protected $aktif;
	public function getAktif() {
		return $this->aktif;
	}
	
	/**
	 * Kolom keterangan
	 * 
	 * @Orm\Column(name="KETERANGAN", type="string", nullable=true)
	 */
	protected $keterangan;
	public function getKeterangan() {
		return $this->keterangan;
	}
	
	/**
	 * List user yang berada dalam role ini.
	 * 
	 * @Orm\ManyToMany(targetEntity="Application\Entity\User", mappedBy="roles")
	 */
	protected $users;
	public function getUsers() {
		return $this->users;
	}
}