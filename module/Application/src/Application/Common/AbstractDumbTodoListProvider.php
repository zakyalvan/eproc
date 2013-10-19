<?php
namespace Application\Common;

use Application\Todo\TodoListProviderInterface;
use Zend\Stdlib\InitializableInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityManager;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

abstract class AbstractDumbTodoListProvider implements TodoListProviderInterface, InitializableInterface, ServiceLocatorAwareInterface {
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator;
	
	/**
	 * @var array
	 */
	protected $contexDatas = array();
	
	/**
	 * @var array
	 */
	protected $requiredContextDataKeys = array();
	
	/**
	 * @var array
	 */
	protected $searchableParams = array();
	
	/**
	 * @var Form
	 */
	protected $searchForm;
	
	/**
	 * Initialize list data provider.
	 * Untuk sementara, method ini belum dapat menggunakan property yang diinject oleh initializer, 
	 * misalnya service-locator. Jadi hanya digunakan misalnya untuk inisiasi search form dll.
	 */
	abstract public function init();
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\ListProviderInterface::setContextDatas()
	 */
	public function setContextDatas(array $contexDatas, $partial = true) {
		if(!$partial) {
			$this->validateContextDatas($contexDatas);
		}
		$this->contexDatas = array_merge($this->contexDatas, $contexDatas);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\Searchable::getSearchableParams()
	 */
	public function getSearchableParams() {
		return $this->searchableParams;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\Searchable::getSearchForm()
	 */
	public function getSearchForm() {
		if(!$this->searchForm) {
			throw new \RuntimeException(sprintf('Search form belum dicreate.'), 100, null);
		}
		return $this->searchForm;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\ListProviderInterface::getListData()
	 */
	public function getListData($pageNumber, $itemCountPerPage, $criterias = array()) {
		$this->validateContextDatas();
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$paginatorAdapter = new ArrayAdapter($this->buildArrayOfObject($entityManager));
		$paginator = new Paginator($paginatorAdapter);
		$paginator->setCurrentPageNumber($pageNumber);
		$paginator->setItemCountPerPage($itemCountPerPage);
		
		return $paginator;
	}
	
	/**
	 * @param EntityManager $entityManager
	 * @return array
	 */
	abstract protected function buildArrayOfObject(EntityManager $entityManager);
	
	/**
	 * Validate contect datas yang diberikan. Apakah sesuai dengan konteks data yang diberikan atau tidak.
	 * 
	 * @param unknown $contextDatas
	 * @throws \InvalidArgumentException
	 */
	protected function validateContextDatas($contextDatas = array()) {
		foreach ($this->requiredContextDataKeys as $requiredKey) {
			if(!array_key_exists($requiredKey, $this->contexDatas)) {
				throw new \InvalidArgumentException(sprintf(
					'Context-datas untuk list-provider %s yang diberikan tidak sesuai dengan konteks data yang dibutuhkan. Key context data yang diberikan [%s] sementara key yang dibutuhkan [%s]', 
					get_called_class(),
					implode(', ', array_keys($this->contexDatas)), 
					implode(', ', $this->requiredContextDataKeys)
				), 100, null);
			}
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
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