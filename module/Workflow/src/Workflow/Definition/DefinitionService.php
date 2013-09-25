<?php
namespace Workflow\Definition;

/**
 * Implementasi default dari {@link DefinitionServiceInterface}
 * 
 * @author zakyalvan
 */
class DefinitionService implements DefinitionServiceInterface {
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::createWorkflow()
	 */
	function createWorkflow($datas) {
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::getWorkflow()
	 */
	function getWorkflow($workflowId){
		
	}
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Definition\DefinitionServiceInterface::isRegisteredWorkflow()
	 */
	function isRegisteredWorkflow($workflowId) {
		
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
}