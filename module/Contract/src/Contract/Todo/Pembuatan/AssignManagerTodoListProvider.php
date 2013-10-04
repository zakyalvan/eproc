<?php
namespace Contract\Todo\Pembuatan;

use Application\Todo\TodoListProvider;
use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Paginator\Paginator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;

/**
 * To do list provider assign pengelola kontrak, setiap kali tender pengadaan baru selesai.
 * 
 * @author zakyalvan
 */
class AssignManagerTodoListProvider implements TodoListProvider, ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Todo\TodoListProvider::getTodoList()
	 */
	public function getTodoList($pageNumber, $itemCountPerPage, $additionalDatas = array()) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$query = $entityManager->createQuery('SELECT tender Procurement\Entity\Tender tender INNER JOIN tender.kontraks WHERE tender.pembuatanKontrak=:pembuatanKontrak')
			->setParameter('pembuatanKontrak', '0');
		
		$adapter = new DoctrinePaginatorAdapter(new DoctrinePaginator($query));
		
		$paginator = new Paginator($adapter);
		$paginator->setCurrentPageNumber($pageNumber);
		$paginator->setItemCountPerPage($itemCountPerPage);
		
		return $paginator;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
	 */
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}