<?php
namespace Contract\Service;

use Contract\Entity\PenunjukanPengelola;

/**
 * Kontrak untuk service yang menangani inisiasi kontrak.
 * 
 * @author zakyalvan
 */
interface InitiateServiceInterface {
	/**
	 * Simpan data penunjukan pengelola kontrak.
	 * Setelah penyimpanan data penunjukan, sebuah instance workflow baru harus dimulai,
	 * berdasarkan data tender yang terkait.
	 * 
	 * @param unknown $penujukanPengelola
	 */
	public function savePenunjukanPengelola(PenunjukanPengelola $penujukanPengelola);
}