<?php
namespace Contract\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Paginator\Paginator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginate;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;

/**
 * Abstract kelas untuk contract list privider.
 * Seharusnya kelas ini dibikin instance-nya dalam service locator.
 * Kelas ini spesifik menggunakan doctrine orm, kelas turunanan dari kelas ini hanya perlu mengimplementasi satu method.
 * 
 * @author zakyalvan
 */
abstract class AbstractContractListProvider implements ContractListProviderInterface, ServiceLocatorAware {
	const KONTRAK_HARGA_SATUAN_LIST_PROVIDER = 'Contract\Service\HargaSatuanContract';
	
	/**
	 * @var ServiceLocator
	 */
	protected $serviceLocator;
	/**
	 * @var array
	 */
	protected $contextDatas = array();
	
	/**
	 * Key dari contextData yang valid untuk contract-list-provider tertentu.
	 * 
	 * @var array
	 */
	protected $validContextDataKeys = array();
	
	public function __construct() {
		$this->init();
	}
	
	/**
	 * Method yang dapat digunakan untuk inisiasi contract list provider.
	 * Misalnya untuk mendefiniskan context datas dan context-data-keys yang valid.
	 */
	abstract protected function init();
	
	public function setContextDatas(array $contextDatas) {
		foreach ($this->validContextDataKeys as $key) {
			if(array_key_exists($key, $this->contextDatas) || array_key_exists($key, $contextDatas)) {
				$keysProvided = array_merge(array_keys($this->contextDatas), array_keys($contextDatas));
				throw new \InvalidArgumentException(sprintf('Context data dengan key %s belum diberikan. Yang telah diberikan %s', $key, implode(', ', $keysProvided)), 100, null);
			}
		}
		$this->contextDatas = array_merge($this->contextDatas, $contextDatas);
	}
	public function getContractList($pageNumber, $itemCountPerPage, $criterias = array()) {
		/* @var $entityManager  EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$queryBuilder = $entityManager->createQueryBuilder();
		$query = $this->buildQuery($queryBuilder, $this->contextDatas, $criterias);
		
		if(!$query instanceof Query) {
			throw new \BadMethodCallException(sprintf('Nilai balikan dari method buildQuery bukan instance dari class Doctrine\ORM\Query, %s diberikan.', is_object($query) ? get_class($query) : $query), 100, null);
		}
		
		$doctrinePaginator = new DoctrinePaginate($query);
		$paginatorAdapter = new PaginatorAdapter($doctrinePaginator);
		
		$paginator = new Paginator($paginatorAdapter);
		$paginator->setCurrentPageNumber($pageNumber);
		$paginator->setItemCountPerPage($itemCountPerPage);
		
		return $paginator;
	}
	
	/**
	 * Build query untuk retrieve list contract.
	 * 
	 * @param QueryBuilder $queryBuilder
	 */
	abstract protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas, $criterias = array());
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}