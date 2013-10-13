<?php
namespace Workflow\Definition;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
/**
 * Implementasi default dari {@link DefinitionServiceInterface}
 * 
 * @author zakyalvan
 */
class DefinitionService implements DefinitionServiceInterface, ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::createWorkflow()
	 */
	public function createWorkflow($datas) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::getWorkflow()
	 */
	public function getWorkflow($workflowId, $populateRelations = false) {
		if(!$this->isRegisteredWorkflow($workflowId)) {
			throw new InvalidArgumentException(sprintf('Parameter workflow id (%s) yang diberikan tidak valid, data workflow tidak ditemukan dalam database definisi workflow.', $workflowId), 100, null);
		}
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$queryBuilder = $entityManager->createQueryBuilder();
		$queryBuilder->select('workflow')
			->from('Workflow\Entity\Workflow', 'workflow')
			->where($queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->setParameter('workflowId', $workflowId);
		
		if($populateRelations) {
			$queryBuilder->innerJoin('workflow.places', 'places')
				->innerJoin('workflow.transitions', 'transitions')
				->innerJoin('workflow.places', 'places');
		}
		
		return $queryBuilder->getQuery()->getSingleResult();
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::isRegisteredWorkflow()
	 */
	public function isRegisteredWorkflow($workflowId) {
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$queryBuilder = $entityManager->createQueryBuilder();
		$exists = $queryBuilder->select('CASE WHEN COUNT(workflow) = 1 THEN 1 ELSE 0 END')
			->from('Workflow\Entity\Workflow', 'workflow')
			->where($queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->setParameter('workflowId', $workflowId)
			->getQuery()
			->getSingleScalarResult();
		return $exists == 1 ? true : false;
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::listWorkflows()
	 */
	function listWorkflows($page = null, $rownums = null) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::deleteWorkflow()
	 */
	function deleteWorkflow($workflowId) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::validateWorkflow()
	 */
	function validateWorkflow($workflowId) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::createPlace()
	 */
	function createPlace($workflowId, $placeDatas) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::getPlace()
	 */
	function getPlace($workflowId, $placeId) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::listPlaces()
	 */
	
	function listPlaces($workflowId, $page = null, $rownums = null) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::deletePlace()
	 */
	function deletePlace($workflowId, $placeId) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::createTransition()
	 */
	function createTransition($workflowId, $transitionDatas) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::getTransition()
	 */
	function getTransition($workflowId, $transitionId) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::listTransitions()
	 */
	function listTransitions($workflowId, $page = null, $rownums = null) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::deleteTransition()
	 */
	function deleteTransition($workflowId, $transitionId) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::createArc()
	 */
	function createArc($workflowId, $placeId, $transitionId, $datas = array()) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::validateArc()
	 */
	function validateArc($workflowId, $placeId, $transitionId, $datas = array()) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::getArc()
	 */
	function getArc($workflowId, $placeId, $transitionId) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::listArcs()
	 */
	function listArcs($workflowId, $page = -1, $rownums = -1) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::deleteArc()
	 */
	function deleteArc($workflowId, $placeId, $transitionId) {
		
	}
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}