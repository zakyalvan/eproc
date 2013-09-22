<?php
namespace Workflow\Service;

use Workflow\Service\DefinitionService;
use Doctrine\ORM\EntityManager;

/**
 * Default implementation dari interface {@link DefinitionService}
 * 
 * @author zakyalvan
 */
class DefaultDefinitionService implements DefinitionService {
	/**
	 * @var EntityManager
	 */
	private $entityManager;
	
	public function __construct(EntityManager $entityManager) {
		if($entityManager == null) {
			throw new ServiceException('Parameter entity manager harus diberikan untuk kelas ' . __CLASS__);
		}
		$this->entityManager = $entityManager;
	}
	
	public function createWorkflow($datas) {
		
	}
	public function getWorkflow($workflowId) {
		
	}
	public function isRegisteredWorkflow($workflowId) {
	
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Service\DefinitionService::listWorkflows()
	 */
	public function listWorkflows($page = null, $rownums = null) {
		return $this->entityManager->getRepository('Workflow\Entity\Workflow')->findAll();
	}
	public function deleteWorkflow($workflowId) {
		
	}
	public function validateWorkflow($workflowId) {
		
	}
	
	
	public function createPlace($workflowId, $placeDatas) {
		
	}
	public function getPlace($workflowId, $placeId) {
		
	}
	public function listPlaces($workflowId, $page = null, $rownums = null) {
		
	}
	public function deletePlace($workflowId, $placeId) {
		
	}
	
	public function createTransition($workflowId, $transitionDatas) {
		
	}
	public function getTransition($workflowId, $transitionId) {
		
	}
	public function listTransitions($workflowId, $page = null, $rownums = null) {
		
	}
	public function deleteTransition($workflowId, $transitionId) {
		
	}
	
	
	public function createArc($workflowId, $placeId, $transitionId, $datas = array()) {
		
	}
	public function validateArc($workflowId, $placeId, $transitionId, $datas = array()) {
		
	}
	public function getArc($workflowId, $placeId, $transitionId) {
		
	}
	public function listArcs($workflowId, $page = -1, $rownums = -1) {
		
	}
	public function deleteArc($workflowId, $placeId, $transitionId) {
		
	}
}