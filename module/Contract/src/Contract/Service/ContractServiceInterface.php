<?php
namespace Contract\Service;

use Contract\Entity\Kontrak\Kontrak;
/**
 * Interface untuk penanganan kontrak.
 * 
 * @author zakyalvan
 */
interface ContractServiceInterface {
	/**
	 * Apakah tender yang diberikan dapat dibuatkan kontraknya.
	 * 
	 * @param Tender|array $tender
	 */
	public function canCreateContractForTender($tender);
	
	/**
	 * Apakah kontrak untuk tender yang diberikan sudah terdaftar atau belum.
	 * 
	 * @param unknown $tender
	 */
	public function hasContractForTender($tender);
	
	/**
	 * Retrieve (atau bikin dan simpan jika belum ada)
	 *
	 * @param unknown $tender
	 * @throws \InvalidArgumentException
	 * @return \Contract\Entity\Kontrak\Kontrak
	 */
	public function getContractForTender($tender);
	
	/**
	 * Save draft kontrak.
	 * 
	 * @param Kontrak $kontrak
	 * @param boolean $final Apakah yang disimpan ini sudah final (Dan lanjut ke proses selanjutnya) atau masih akan diubah
	 */
	public function saveDraft(Kontrak $kontrak, $final);
	
	/**
	 * Apakah kontrak yang diberikan diapprove atau tidak.
	 * 
	 * @param Kontrak $kontrak
	 * @param booelan $approval
	 */
	public function setApproval(Kontrak $kontrak, $approval);
	
	/**
	 * Pembuatan bkh. (???)
	 * 
	 * @param Kontrak $kontrak
	 * @param boolean $final Apakah versi akhir atau masih draft.
	 */
	public function createBkh(Kontrak $kontrak, $final);
	
	/**
	 * Finalisasi kontrak.
	 * 
	 * @param Kontrak $kontrak
	 * @param boolean apakah sudah final dan dilanjut ke proses selanjutnya atau disimpan sebagai draft dulu.
	 */
	public function finalizeDraft(Kontrak $kontrak, $final);
	
	/**
	 * Apakah kontrak yang diberikan teregistrasi dalam database atau tidak.
	 * 
	 * @param Kontrak|array $kontrak
	 */
	public function isRegisteredContract($kontrak);
}