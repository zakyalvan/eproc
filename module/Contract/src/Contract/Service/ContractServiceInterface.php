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
	 */
	public function saveContractDraft(Kontrak $kontrak);
	
	/**
	 * Apakah kontrak yang diberikan teregistrasi dalam database atau tidak.
	 * 
	 * @param Kontrak|array $kontrak
	 */
	public function isRegisteredContract($kontrak);
}