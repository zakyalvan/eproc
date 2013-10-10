<?php
namespace Procurement\Validator;

use Zend\Validator\AbstractValidator;
use Doctrine\ORM\EntityRepository;

/**
 * Apakah identity vendor yang diberikan valid atau tidak.
 * Validator ini dependent ke Doctrine.
 * 
 * @author zakyalvan
 */
class RegisteredTenderIdentity extends AbstractValidator {
	/**
	 * @var EntityRepository
	 */
	private $entityRepository;
	
	public function __construct($options = null) {
		parent::__construct($options);
	}
	
	public function setEntityRepository(EntityRepository $entityRepository) {
		$this->entityRepository = $entityRepository;
	}
	
	public function isValid($value) {
		
	}
}