<?php
namespace Procurement\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity yang faftar status dalam proses pengadaan pengadaan
 * 
 * @Orm\Entity(readOnly=true)
 * @Orm\Table(name="EP_PGD_STATUS")
 * 
 * @author zakyalvan
 */
class Status {
	const KODE_KALAH_EVALUASI_HARGA = -8;
	const KODE_TIDAK_LOLOS_VERIFIKASI = -7;
	const KODE_TIDAK_LULUS_EVALUASI_TEKNIS = -5;
	const KODE_TIDAK_LOLOS_VERIFIKASI = -4;
	const KODE_TIDAK_MENGIRIM_PENAWARAN = -3;
	const KODE_TIDAK_MENGIKUTI_PENGADAAN = -2;
	const KODE_TIDAK_MENGIKUTI_PENGADAAN = -1;
	const KODE_BELUM_MENDAFTAR = 1;
	const KODE_BELUM_MENGIRIM_PENAWARAN = 2;
	const KODE_EDIT_ATAU_KIRIM_ULANG_PENAWARAN = 3;
	const KODE_LOLOS_VERIFIKASI = 4;
	const KODE_LULUS_EVALUASI_TEKNIS = 5;
	const KODE_MASA_SANGGAN_TEKNIS = 6;
	const KODE_LOLOS_VERIFIKASI = 7;
	const KODE_DICALONKAN_MENJADI_PEMENANG = 8;
	const KODE_MASA_SANGGAH_HARGA = 9;
	const KODE_NEGOSIASI = 10;
	const KODE_PENUNJUKAN_PEMENANG = 11;
	const KODE_BELUM_MENGIRIM_PENAWARAN = 20;
	const KODE_EDIT_ATAU_KIRIM_ULANG_PENAWARAN = 21;
	const KODE_PEMBUKAAN_PENAWARAN_TEKNIS = 22;
	const KODE_PEMBUKAAN_PENAWARAN_HARGA = 23;
	const KODE_SELESAI_PENGADAAN_TELAH_KOMPLIT = 24;
	const KODE_SELESAI_PENGADAAN_DIULANG = 25;
	const KODE_SELESAI_PENGADAAN_DIBATALKAN = 26;
	
	public function __construct($kode) {
		$this->kode = $kode;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_STATUS", type="integer")
	 * @Orm\GeneratedValue(strategy="NONE")
	 * 
	 * @var string
	 */
	private $kode;
	public function getKode() {
		return $this->kode;
	}
	
	/**
	 * @Orm\Column(name="NAMA_STATUS", type="string", length=64)
	 * 
	 * @var unknown
	 */
	private $nama;
	public function getNama() {
		return $this->nama;
	}
}