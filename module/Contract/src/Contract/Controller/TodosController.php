<?php
namespace Contract\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;

/**
 * Kelas kontroler yang mewakili halaman utama modul kontrak.
 * Sebenarnya hanya untuk nampilin todo list untuk masing-masing pengelola kontrak.
 *
 * @author zakyalvan
 */
class TodosController extends AbstractActionController {
	public function indexAction() {
		$viewDatas = array(
			"pageTitle" => "Kontrak - Daftar Pekerjaan",
			"content" => "kontrak/todos/index",
			"contentData" => array()
		);
		return new ViewModel($viewDatas);
	}
	
	/**
	 * Tampilin daftar pengadaan yang menunggu pembuatan kontrak.
	 */
	public function initiationAction() {
		
	}
	
	public function jobAction() {
		
	}
	
	public function ammendAction() {
		
	}
	
	public function workOrderAction() {
		
	}
	
	public function progressAction() {
		
	}
	
	public function todo_tagihan() {
		
	}
}