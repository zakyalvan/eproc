<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Contract\Form\DelegateCreationForm;

/**
 * Kelas kontroler ini mewakili aktifitas-aktifitas dalam proses flow 
 * C.1 - Pembuatan Kontrak.
 * 
 * @author zakyalvan
 */
class CreateController extends AbstractActionController {
	/**
	 * List draft kontrak.
	 */
	public function indexAction() {
		
	}
	
	/**
	 * Delegasikan pembuatan kontrak kepada bawahan.
	 * Disinilah workflow instance untuk pembuatan kontrak dimulai.
	 */
	public function delegateAction() {
		
		
		if($this->getRequest()->isPost()) {
			
		}
		
		// Render form delegate, tampilin data pengadaan yang akan dibuatkan kontraknya.
		return array(
			
		);
	}
	
	/**
	 * Pembuatan draft kontrak baru
	 */
	public function draftAction() {
		
		// Proses input data draft kontrak dari user.
		if($this->getRequest()->isPost()) {
			
		}
		
		// Render form create draft kontrak.
		return array(
			"pageTitle" => "Kontrak - Pembuatan Draft",
			"contentData" => array()
		);
	}
	
	/**
	 * Review draft kontrak, aktifitas ini akan dilakuakan oleh user
	 * setelah proses pembuatan kontrak baru (jika type kontrak adalah perjanjian).
	 */
	public function reviewAction() {
		// Render informasi dan form review draft kontrak.
		return array(
			"pageTitle" => "Kontrak - Review Draft",
		);
	}
	
	/**
	 * Approval yang harus dilakukan setelah proses review draft kontrak oleh user dilakukan.
	 */
	public function approvalAction() {
		// Render informasi dan form approval draft kontrak.
		return array(
			"pageTitle" => "Kontrak - Persetujuan Draft"
		);
	}
	
	/**
	 * Pembuatan kbh setelah draft kontrak di setujui.
	 */
	public function kbhAction() {
		// Render informasi dan form approval draft kontrak.
		return array(
			"pageTitle" => "Kontrak - Pembuatan KBH",
		);
	}
	
	/**
	 * Aktifitas terakhir finalisasi/inisiasi kontrak setelah draft kontrak 
	 * disetujui (jika type kontrak adalah perjanjian) atau setelah pembuatan draft kontrak,
	 * jika type kontrak adalah spk.
	 */
	public function finalizeAction() {
		
		// Render informasi dan form inisiasi kontrak.
		return array(
			"pageTitle" => "Kontrak - Finalisasi Draft"
		);
	}
}