<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Place;
use Workflow\Entity\Arc;
use Workflow\Entity\Workflow;
use Doctrine\ORM\Query\Expr\Join;
use Workflow\Entity\Transition;
use Doctrine\ORM\UnitOfWork;

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
		return $queryBuilder->select('place')
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
		$queryBuilder = $this->_em->createQueryBuilder();
		$queryBuilder->select('place')
			->from('Workflow\Entity\Place', 'place')
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('place.type', ':placeType'))
			->setParameter('placeType', Place::TYPE_INTERMEDIATE_PLACE)
			->setParameter('workflowId', $workflowId)
			->getQuery()
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
		$queryBuilder = $this->_em->createQueryBuilder();
		$queryBuilder->select('place')
			->from('Workflow\Entity\Place', 'place')
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('place.type', ':placeType'))
			->setParameter('placeType', Place::TYPE_END_PLACE)
			->setParameter('workflowId', $workflowId)
			->getQuery()
			->getSingleResult();
	}
	
	/**
	 * Count input places kepada sebuah transisi dalam sebuah workflow.
	 *
	 * @param unknown $transition
	 * @param unknown $workflow
	 * @return integer
	 */
	public function countInputPlaces($transition, $workflow) {
		$transitionId = $transition;
		if($transition instanceof Transition) {
			$transitionId = $transition->getId();
		}
	
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}
	
		$queryBuuilder = $this->_em->createQueryBuilder();
		return $queryBuuilder->select($queryBuuilder->expr()->count('place'))
			->from('Workflow\Entity\Place', 'place')
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuuilder->expr()->eq('workflow.id', ':workflowId'))
			->innerJoin('place.arcs', 'arcs', Join::WITH, $queryBuuilder->expr()->eq('arcs.direction', ':arcDirection'))
			->innerJoin('arcs.transition', 'transition', Join::WITH, $queryBuuilder->expr()->eq('transition.id', ':transitionId'))
			->setParameter('workflowId', $workflowId)
			->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
			->setParameter('transitionId', $transitionId)
			->getQuery()
			->getSingleScalarResult();
	}
	
	/**
	 * Retrieve input place kepada sebuah transisi dalam sebuah workflow.
	 * 
	 * @param unknown $transition
	 * @param unknown $workflow
	 * @return array
	 */
	public function getInputPlaces($transition, $workflow) {
		$transitionId = $transition;
		if($transition instanceof Transition) {
			$transitionId = $transition->getId();
		}
		
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}
		
		$queryBuuilder = $this->_em->createQueryBuilder();
		return $queryBuuilder->select('place')
			->from('Workflow\Entity\Place', 'place')
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuuilder->expr()->eq('workflow.id', ':workflowId'))
			->innerJoin('place.arcs', 'arcs', Join::WITH, $queryBuuilder->expr()->eq('arcs.direction', ':arcDirection'))
			->innerJoin('arcs.transition', 'transition', Join::WITH, $queryBuuilder->expr()->eq('transition.id', ':transitionId'))
			->setParameter('workflowId', $workflowId)
			->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
			->setParameter('transitionId', $transitionId)
			->getQuery()
			->getResult();
	}
	
	/**
	 * Retrieve output place.
	 *
	 * @param unknown $transition
	 * @param unknown $workflow
	 * @throws \InvalidArgumentException
	 * @return integer
	 */
	public function getOutputPlaces($transition, $workflow) {
		$transitionId = $transition;
		$workflowId = $workflow;
	
		if($transition instanceof Transition) {
			$transitionId = $transition->getId();
				
			$transitionState = $this->_em->getUnitOfWork()->getEntityState($transition);
			if($transitionState == UnitOfWork::STATE_DETACHED || $transitionState == UnitOfWork::STATE_MANAGED) {
				$transition = $this->_em->merge($transition);
				$workflowId = $transition->getWorkflow()->getId();
			}
		}
	
		if($workflow instanceof Workflow) {
			if($workflow->getId() !== $workflowId) {
				throw new \InvalidArgumentException('Parameter yang diberikan tidak valid', 100, null);
			}
		}
	
		$queryBuuilder = $this->_em->createQueryBuilder();
		return $queryBuuilder->select('place')
			->from('Workflow\Entity\Place', 'place')
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuuilder->expr()->eq('workflow.id', ':workflowId'))
			->innerJoin('place.arcs', 'arcs', Join::WITH, $queryBuuilder->expr()->eq('arcs.direction', ':arcDirection'))
			->innerJoin('arcs.transition', 'transition', Join::WITH, $queryBuuilder->expr()->eq('transition.id', ':transitionId'))
			->setParameter('workflowId', $workflowId)
			->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
			->setParameter('transitionId', $transitionId)
			->getQuery()
			->getSingleScalarResult();
	}
	
	/**
	 * Retrieve output place.
	 * 
	 * @param unknown $transition
	 * @param unknown $workflow
	 * @throws \InvalidArgumentException
	 * @return array
	 */
	public function getOutputPlaces2($transition, $workflow) {
		$transitionId = $transition;
		$workflowId = $workflow;
		
		if($transition instanceof Transition) {
			$transitionId = $transition->getId();
			
			$transitionState = $this->_em->getUnitOfWork()->getEntityState($transition);
			if($transitionState == UnitOfWork::STATE_DETACHED || $transitionState == UnitOfWork::STATE_MANAGED) {
				/* @var $transition Transition */
				$transition = $this->_em->merge($transition);
				$workflowId = $transition->getWorkflow()->getId();
			}
		}
		
		if($workflow instanceof Workflow) {
			if($workflow->getId() !== $workflowId) {
				throw new \InvalidArgumentException('Parameter yang diberikan tidak valid', 100, null);
			}
		}
		
		$queryBuuilder = $this->_em->createQueryBuilder();
		return $queryBuuilder->select('place')
			->from('Workflow\Entity\Place', 'place')
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuuilder->expr()->eq('workflow.id', ':workflowId'))
			->innerJoin('place.arcs', 'arcs', Join::WITH, $queryBuuilder->expr()->eq('arcs.direction', ':arcDirection'))
			->innerJoin('arcs.transition', 'transition', Join::WITH, $queryBuuilder->expr()->eq('transition.id', ':transitionId'))
			->setParameter('workflowId', $workflowId)
			->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
			->setParameter('transitionId', $transitionId)
			->getQuery()
			->getResult();
	}
	
	protected function ensureManagedEntity($entity) {
		if($entity == null) {
			throw new \InvalidArgumentException('Parameter entity tidak boleh null', 100, null);
		}
	
		$entityState = $this->getEntityManager()->getUnitOfWork()->getEntityState($entity);
		if(!($entityState == UnitOfWork::STATE_MANAGED || $entityState == UnitOfWork::STATE_DETACHED)) {
			throw new \InvalidArgumentException(sprintf('Parameter entity harus instance dari object entity dengan state manage atau detached'), 100, null);
		}
	
		if($entityState == UnitOfWork::STATE_DETACHED) {
			return $this->getEntityManager()->merge($entity);
		}
		return $entity;
	}
}