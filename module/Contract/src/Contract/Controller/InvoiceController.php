<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Kelas kontroler ini mewakili aktifitas-aktifitas dalam proses flow
 * C.4 - Penagihan dan Pembayaran Kontrak.
 * Sebagai catatan, proses ini dimulai atau ditrigger dari aplikasi eksternal.
 *
 * @author zakyalvan
 */
class InvoiceController extends AbstractActionController {
	public function indexAction() {
		
	}
	
	/**
	 * Verifikasi dan perhitungan denda.
	 * Aktifitas C.4.2
	 */
	public function verify() {
		
	}
}