<?php
namespace Application\Todo;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;

/**
 * Implementasi dasar dari {@link TodoListProviderInterface}.
 * Doctrine base dan harus diinisiasi dalam service locator atau supply manual object {@link ServiceLocatorAwareInterface}
 * 
 * @author zakyalvan
 */
abstract class AbstractTodoListProvider implements TodoListProviderInterface, ServiceLocatorAwareInterface {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * @var array
	 */
	private $searchableParameters = array();
	
	public function __construct() {
		$this->initSearchableParameters($this->searchableParameters);
	}
	
	/**
	 * Initialize object ini.
	 */
	abstract protected function initSearchableParameters($searchableParameters);
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Todo\TodoListProvider::getTodoList()
	*/
	public function getTodoList($pageNumber, $itemCountPerPage, $searchCriterias = array(), $additionalDatas = array()) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		$queryBuilder = $entityManager->createQueryBuilder();
		
		foreach ($searchCriterias as $key => $value) {
			if(!array_key_exists($key, $this->searchableParameter)) {
				throw new \InvalidArgumentException(sprintf('Parameter search %s dengan value %s yang diberikan tidak valid.', $key, $value), $code, $previous);
			}
		}
		
		$query = $this->buildTodoListQuery($queryBuilder, $searchCriterias, $additionalDatas);
		$paginatorAdapter = new DoctrinePaginatorAdapter(new DoctrinePaginator($query));
		return new Paginator($paginatorAdapter);
	}
	
	/**
	 * Build todo list query.
	 * 
	 * @param QueryBuilder $queryBuilder
	 * @param array $searchCriterias
	 * @param array $additionalDatas
	 * 
	 * @return Query
	 */
	abstract protected function buildTodoListQuery(QueryBuilder $queryBuilder, $searchCriterias = array(), $additionalDatas = array());
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Todo\TodoListProvider::getSearchableParameter()
	 */
	public function getSearchableParameters() {
		$searchableParameters = array();
		foreach ($this->searchableParameter as $key => $parameter) {
			$searchableParameters[$key] = $parameter['label'];
		}
		return $searchableParameters;
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