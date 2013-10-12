<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Place;
use Workflow\Entity\Arc;
use Workflow\Entity\Workflow;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Custom repository untuk entity place.
 * 
 * @author zakyalvan
 */
class PlaceRepository extends EntityRepository {
	private function isValidWorkflowId($workflowId) {
		$workflowCount = $this->_em->createQuery('SELECT COUNT(workflow) FROM Workflow\Entity\Workflow AS workflow WHERE workflow.id = :workflowId')
			->setParameter('workflowId', $workflowId)
			->getSingleScalarResult();
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
			throw new \InvalidArgumentException(sprintf('Parameter workflow (id = %s) yang diberikan tidak valid, tidak ditemukan dalam database definisi workflow', $workflowId), 100, null);
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$queryBuilder->select('place')
			->from('Workflow\Entity\Place', 'place')
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('place.type', ':placeType'))
			->setParameter('placeType', Place::TYPE_START_PLACE)
			->setParameter('workflowId', $workflowId)
			->getQuery()
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