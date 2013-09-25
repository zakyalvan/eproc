<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Place;
use Workflow\Entity\Arc;
use Workflow\Entity\Workflow;

/**
 * Custom repository untuk entity place.
 * 
 * @author zakyalvan
 */
class PlaceRepository extends EntityRepository {
	private function isValidWorkflowId($workflowId) {
		$workflowCount = $this->_em->createQuery('SELECT COUNT(workflow) FROM Workflow\Entity\Workflow AS workflow WHERE workflow.id = :workflowId')
			->setParameter('workflowId', $workflowId)
			->getScalarResult();
		return $workflowCount == 1;
	}
	
	/**
	 * Retrieve start place untuk workflow yang diberikan.
	 * 
	 * @param unknown $workflow
	 */
	public function getStartPlace($workflow) {
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}
		
		if(!$this->isValidWorkflowId($workflowId)) {
			throw new \InvalidArgumentException('Parameter workflow yang diberikan tidak valid', 100, null);
		}
		
		return $this->_em->createQuery('SELECT place FROM Workflow\Entity\Place AS place INNER JOIN place.workflow WITH place.workflow.id = :workflowId WHERE place.type = :placeType')
			->setParameter('placeType', Place::TYPE_START_PLACE)
			->setParameter('workflowId', $workflow->getId())
			->getSingleResult();
	}
	/**
	 * Retrieve intermediate places untuk workflow yang diberikan.
	 * 
	 * @param unknown $workflow
	 */
	public function getIntermediatePlaces($workflow) {
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}
		
		if(!$this->isValidWorkflowId($workflowId)) {
			throw new \InvalidArgumentException('Parameter workflow yang diberikan tidak valid', 100, null);
		}
		return $this->_em->createQuery('SELECT place FROM Workflow\Entity\Place AS place INNER JOIN place.workflow WITH place.workflow.id = :workflowId WHERE place.type = :placeType')
			->setParameter('placeType', Place::TYPE_INTERMEDIATE_PLACE)
			->setParameter('workflowId', $workflow->getId())
			->getResult();
	}
	/**
	 * Retrieve end place untuk workflow yang diberikan.
	 * 
	 * @param unknown $workflow
	 */
	public function getEndPlace($workflow) {
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}

		if(!$this->isValidWorkflowId($workflowId)) {
			throw new \InvalidArgumentException('Parameter workflow yang diberikan tidak valid', 100, null);
		}
		return $this->_em->createQuery('SELECT place FROM Workflow\Entity\Place AS place INNER JOIN place.workflow WITH place.workflow.id = :workflowId WHERE place.type = :placeType')
			->setParameter('placeType', Place::TYPE_END_PLACE)
			->setParameter('workflowId', $workflow->getId())
			->getSingleResult();
	}
}