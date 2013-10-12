<?php
namespace Application\Common;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Form\Form;
use Zend\Stdlib\InitializableInterface as Initializable;
use Zend\Paginator\Paginator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * Implementasi dasar untuk list provider. Spesifik zend dan menggunakan doctrine.
 * Kelas turunan dari kelas ini seharusnya dibikin instance-nya dalam service-manager.
 * 
 * @author zakyalvan
 */
abstract class AbstractListProvider implements SearchableListProviderInterface, ServiceLocatorAware, Initializable {
	/**
	 * @var ServiceLocator
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
	 * Ini parameter khusus untuk doctrine paginator.
	 * 
	 * @var bool
	 */
	protected $fetchJoinCollection = false;
	
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
		
		$queryBuilder = $entityManager->createQueryBuilder();
		
		$query = $this->buildQuery($queryBuilder, $this->contexDatas, $criterias);
		if($query != null && !($query instanceof Query || $query instanceof QueryBuilder)) {
			throw new \BadMethodCallException('Return dari method buildQuery bukan instance dari Doctrine\Orm\Query atau Doctrine\Orm\QueryBuilder', 100, null);
		}
		
		$doctrinePaginator = new DoctrinePaginator($query, $this->fetchJoinCollection);
		$paginatorAdapter = new PaginatorAdapter($doctrinePaginator);
		
		$paginator = new Paginator($paginatorAdapter);
		$paginator->setCurrentPageNumber($pageNumber);
		$paginator->setItemCountPerPage($itemCountPerPage);
		
		return $paginator;
	}
	
	/**
	 * Build query untuk list-provider.
	 * 
	 * @param QueryBuilder $queryBuilder
	 * @param array $contextDatas
	 * @param array $criterias
	 * 
	 * @return Query|QueryBuilder
	 */
	abstract protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array());
	
	/**
	 * Validate contect datas yang diberikan. Apakah sesuai dengan konteks data yang diberikan atau tidak.
	 * 
	 * @param unknown $contextDatas
	 * @throws \InvalidArgumentException
	 */
	protected function validateContextDatas($contextDatas = array()) {
		foreach ($this->requiredContextDataKeys as $requiredKey) {
			if(array_key_exists($requiredKey, array_keys($this->contexDatas)) || array_key_exists($requiredKey, array_keys($contextDatas))) {
				throw new \InvalidArgumentException(sprintf(
					'Context-datas untuk list-provider %s yang diberikan tidak sesuai dengan konteks data yang dibutuhkan. Key context data yang diberikan [%s] sementara key yang dibutuhkan [%s]', 
					get_called_class(),
					implode(', ', array_merge(array_keys($this->contexDatas), array_keys($contextDatas))), 
					implode(', ', $this->requiredContextDataKeys)
				), 100, null);
			}
		}
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