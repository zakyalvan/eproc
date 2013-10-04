<?php
namespace Contract\Todo;

use Application\Todo\TodoListProvider;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * To do list provider untuk kontrak yang harus diinisiasi.
 * 
 * @author zakyalvan
 */
class InitiateContractTodoListProvider implements TodoListProvider, ObjectManagerAwareInterface {
	/**
	 * @var ObjectManager
	 */
	private $objectManager = null;
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Todo\TodoListProvider::getTodoList()
	 */
	public function getTodoList($page, $rowNums) {
		
	}
	
	public function setObjectManager(ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}
	public function getObjectManager() {
		return $this->objectManager;
	}
}