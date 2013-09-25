<?php
namespace Workflow\Definition;

/**
 * Kontrak untuk definition service.
 * 
 * @author zakyalvan
 */
interface DefinitionServiceInterface {
	/**
	 * Create new workflow. Pada saat create workflow, dua default place juga di-create yaitu
	 * start place dan end place.
	 *
	 * @param unknown $datas
	 */
	function createWorkflow($datas);
	/**
	 * Retrieve workflow berdasarkan id yang diberikan.
	 *
	 * @param unknown $workflowId
	*/
	function getWorkflow($workflowId);
	/**
	 * Apakah workflow terdaftar atau tidak.
	 *
	 * @param unknown $workflowId
	*/
	function isRegisteredWorkflow($workflowId);
	/**
	 * List all workflow definitions, with optional paging capability.
	 *
	 * @param string $page
	 * @param string $rownums
	*/
	function listWorkflows($page = null, $rownums = null);
	/**
	 * Delete workflow definition. Pada saat definisi workflow di-delete, seluruh workflow element
	 * terkait (place, transition dan arc) juga di-delete.
	 *
	 * @param unknown $workflowId
	*/
	function deleteWorkflow($workflowId);
	/**
	 * Validasi workflow.
	 *
	 * @param unknown $workflowId
	*/
	function validateWorkflow($workflowId);
	
	/**
	 * Create place baru. Perlu diingat bahwa place yang dapat dicreate disini hanya intermediate place.
	 * Start dan end place di create pada saat workflow dicreate.
	 *
	 * @param unknown $workflowId
	 * @param unknown $placeDatas
	*/
	function createPlace($workflowId, $placeDatas);
	/**
	 * Retrieve place berdasarkan workflow dan place id nya
	 *
	 * @param unknown $workflowId
	 * @param unknown $placeId
	*/
	function getPlace($workflowId, $placeId);
	/**
	 * List all defined places for supplied workflow.
	 *
	 * @param unknown $workflowId
	 * @param string $page
	 * @param string $rownums
	*/
	function listPlaces($workflowId, $page = null, $rownums = null);
	/**
	 * Delete place. Perlu diperhatikan, place yang boleh dihapus adalah intermediate place.
	 * Start dan end place tidak dapat dihapus kecuali workflow yang bersangkutan dihapus.
	*/
	function deletePlace($workflowId, $placeId);
	
	/**
	 * Create transition baru untuk workflow yang diberikan.
	 *
	 * @param unknown $workflowId
	 * @param unknown $transitionDatas
	*/
	function createTransition($workflowId, $transitionDatas);
	/**
	 * Retrieve transition berdasarkan id yang diberikan.
	 *
	 * @param unknown $workflowId
	 * @param unknown $transitionId
	*/
	function getTransition($workflowId, $transitionId);
	/**
	 * List all transition for specified workflow.
	 *
	 * @param unknown $workflowId
	 * @param string $page
	 * @param string $rownums
	*/
	function listTransitions($workflowId, $page = null, $rownums = null);
	/**
	 * Delete transition berdasarkan id yang diberikan.
	 *
	 * @param unknown $workflowId
	 * @param unknown $transitionId
	*/
	function deleteTransition($workflowId, $transitionId);
	
	/**
	 * Create arc baru.
	 *
	 * @param unknown $workflowId
	 * @param unknown $placeId
	 * @param unknown $transitionId
	 * @param unknown $datas
	*/
	function createArc($workflowId, $placeId, $transitionId, $datas = array());
	/**
	 * Validate arc.
	 *
	 * @param unknown $workflowId
	 * @param unknown $placeId
	 * @param unknown $transitionId
	 * @param unknown $datas
	*/
	function validateArc($workflowId, $placeId, $transitionId, $datas = array());
	/**
	 * Retrieve arc berdasarkan id yang diberikan.
	 *
	 * @param unknown $workflowId
	 * @param unknown $placeId
	 * @param unknown $transitionId
	*/
	function getArc($workflowId, $placeId, $transitionId);
	/**
	 * List seluruh arc berdasarkan id yang diberikan.
	 *
	 * @param unknown $workflowId
	 * @param unknown $page
	 * @param unknown $rownums
	*/
	function listArcs($workflowId, $page = -1, $rownums = -1);
	/**
	 * Delete arc berdsarkan id yang diberikan.
	 *
	 * @param unknown $workflowId
	 * @param unknown $placeId
	 * @param unknown $transitionId
	*/
	function deleteArc($workflowId, $placeId, $transitionId);
}