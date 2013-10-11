<?php
namespace Contract\Service;

use Contract\Entity\Kontrak\Kontrak;
/**
 * Interface untuk penanganan kontrak.
 * 
 * @author zakyalvan
 */
interface ContractServiceInterface {
	public function hasRegisteredContractForTender($tender);
	
	/**
	 * Apakah tender yang diberikan dapat dibuatkan kontraknya.
	 * 
	 * @param Tender|array $tender
	 */
	public function canCreateContractForTender($tender);
	
	/**
	 * Create contract berdasarkan informasi tender.
	 * 
	 * @param Tender|integer $tender
	 * @return Kontrak
	 */
	public function createContractForTender($tender, $persist = false);
	
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