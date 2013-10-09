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
	 * Create contract berdasarkan informasi tender.
	 * 
	 * @param Tender|integer $tender
	 * @return Kontrak
	 */
	public function createContractForTender($tender);
	
	
	/**
	 * Save draft 
	 * 
	 * @param Kontrak $kontrak
	 */
	public function saveContractDraft(Kontrak $kontrak);
}