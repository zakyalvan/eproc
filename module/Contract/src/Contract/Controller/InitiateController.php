<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Kelas kontroler ini mewakili aktifitas-aktifitas dalam proses flow 
 * C.1 - Pembuatan Kontrak.
 * 
 * @author zakyalvan
 */
class InitiateController extends AbstractActionController {
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
		
	}
	
	/**
	 * Pembuatan draft kontrak baru
	 */
	public function createAction() {
		// Proses input data draft kontrak dari user.
		if($this->input->post()) {
			
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
		$viewDatas = array(
			"pageTitle" => "Kontrak - Review Draft",
			"content" => "kontrak/inisiasi/review",
			"contentData" => array()
		);
		$this->load->view("layout_kontrak", $viewDatas);
	}
	
	/**
	 * Approval yang harus dilakukan setelah proses review draft kontrak oleh user dilakukan.
	 */
	public function approvalAction() {
		// Render informasi dan form approval draft kontrak.
		$viewDatas = array(
			"pageTitle" => "Kontrak - Persetujuan Draft",
			"content" => "kontrak/inisiasi/approval",
			"contentData" => array()
		);
		$this->load->view("layout_kontrak", $viewDatas);
	}
	
	/**
	 * Pembuatan kbh setelah draft kontrak di setujui.
	 */
	public function kbhAction() {
		// Render informasi dan form approval draft kontrak.
		$viewDatas = array(
			"pageTitle" => "Kontrak - Pembuatan KBH",
			"content" => "kontrak/inisiasi/kbh",
			"contentData" => array()
		);
		$this->load->view("layout_kontrak", $viewDatas);
	}
	
	/**
	 * Aktifitas terakhir finalisasi/inisiasi kontrak setelah draft kontrak 
	 * disetujui (jika type kontrak adalah perjanjian) atau setelah pembuatan draft kontrak,
	 * jika type kontrak adalah spk.
	 */
	public function finalizeAction() {
		// Render informasi dan form inisiasi kontrak.
		$viewDatas = array(
			"pageTitle" => "Kontrak - Finalisasi Draft",
			"content" => "kontrak/inisiasi/finalize",
			"contentData" => array()
		);
		$this->load->view("layout_kontrak", $viewDatas);
	}
}