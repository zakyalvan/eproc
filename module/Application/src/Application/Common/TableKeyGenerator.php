<?php
namespace Application\Common;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface as ObjectManagerAware;

/**
 * Key generator yang diambil dari table database.
 * 
 * @author zakyalvan
 */
class TableKeyGenerator implements KeyGeneratorInterface, ObjectManagerAware {
	/**
	 * @var ObjectManager
	 */
	private $objectManager;
	
	public function generateNextKey($context, $keyName) {
		return $this->objectManager->getRepository('Application\Entity\GeneratedKey')
			->generateNextKey($context, $keyName);
	}
	
	public function setObjectManager(ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}
	
	public function getObjectManager() {
		return $this->objectManager;
	}
}