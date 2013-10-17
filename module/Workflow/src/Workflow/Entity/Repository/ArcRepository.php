<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Place;
use Workflow\Entity\Transition;
use Doctrine\ORM\Query\Expr\Join;
use Workflow\Entity\Arc;
use Doctrine\ORM\UnitOfWork;

/**
 * Custom repository untuk arc.
 * 
 * @author zakyalvan
 */
class ArcRepository extends EntityRepository {
	public function countInputArcsFrom(Place $place) {
		$place = $this->ensureManagedEntity($place);
	
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select($queryBuilder->expr()->count('arc'))
			->from('Workflow\Entity\Arc', 'arc')
			->innerJoin('arc.place', 'place', Join::WITH, $queryBuilder->expr()->eq('place.id', ':placeId'))
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('arc.direction', ':arcDirection'))
			->setParameter('placeId', $place->getId())
			->setParameter('workflowId', $place->getWorkflow()->getId())
			->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
			->getQuery()
			->getSingleScalarResult();
	}
	
	/**
	 * Retrieve input arcs (arc yang keluar dari sebuah place dan masuk ke sebuah transition) dari sebuah place.
	 * 
	 * @param Place $place
	 */
	public function getInputArcsFrom(Place $place) {
		$place = $this->ensureManagedEntity($place);
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select(array('arc', 'place', 'transition'))
			->from('Workflow\Entity\Arc', 'arc')
			->innerJoin('arc.transition', 'transition')
			->innerJoin('arc.place', 'place', Join::WITH, $queryBuilder->expr()->eq('place.id', ':placeId'))
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('arc.direction', ':arcDirection'))
			->setParameter('placeId', $place->getId())
			->setParameter('workflowId', $place->getWorkflow()->getId())
			->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
			->getQuery()
			->getResult();
	}
	
	
	public function countInputArcsTo(Transition $transition) {
		$transition = $this->ensureManagedEntity($transition);
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select($queryBuilder->expr()->count('arc'))
			->from('Workflow\Entity\Arc', 'arc')
			->innerJoin('arc.transition', 'transition', Join::WITH, $queryBuilder->expr()->eq('transition.id', ':transitionId'))
			->innerJoin('transition.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('arc.direction', ':arcDirection'))
			->setParameter('transitionId', $transition->getId())
			->setParameter('workflowId', $transition->getWorkflow()->getId())
			->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
			->getQuery()
			->getSingleScalarResult();
	}
	/**
	 * Retrieve input arcs (arc yang keluar dari sebuah place dan masuk ke sebuah transition) ke sebuah transition.
	 * 
	 * @param Transition $transition
	 */
	public function getInputArcsTo(Transition $transition) {
		$transition = $this->ensureManagedEntity($transition);
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select(array('arc', 'place', 'transition'))
			->from('Workflow\Entity\Arc', 'arc')
			->innerJoin('arc.place', 'place')
			->innerJoin('arc.transition', 'transition', Join::WITH, $queryBuilder->expr()->eq('transition.id', ':transitionId'))
			->innerJoin('transition.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('arc.direction', ':arcDirection'))
			->setParameter('transitionId', $transition->getId())
			->setParameter('workflowId', $transition->getWorkflow()->getId())
			->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
			->getQuery()
			->getResult();
	}
	
	public function countOutputArcsFrom(Transition $transition) {
		$transition = $this->ensureManagedEntity($transition);
	
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select($queryBuilder->expr()->count('arc'))
			->from('Workflow\Entity\Arc', 'arc')
			->innerJoin('arc.transition', 'transition', Join::WITH, $queryBuilder->expr()->eq('transition.id', ':transitionId'))
			->innerJoin('transition.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('arc.direction', ':arcDirection'))
			->setParameter('transitionId', $transition->getId())
			->setParameter('workflowId', $transition->getWorkflow()->getId())
			->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
			->getQuery()
			->getResult();
	}
	public function getOutputArcsFrom(Transition $transition) {
		$transition = $this->ensureManagedEntity($transition);
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select(array('arc', 'place', 'transition'))
			->from('Workflow\Entity\Arc', 'arc')
			->innerJoin('arc.place', 'place')
			->innerJoin('arc.transition', 'transition', Join::WITH, $queryBuilder->expr()->eq('transition.id', ':transitionId'))
			->innerJoin('transition.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('arc.direction', ':arcDirection'))
			->setParameter('transitionId', $transition->getId())
			->setParameter('workflowId', $transition->getWorkflow()->getId())
			->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
			->getQuery()
			->getResult();
	}
	
	public function countOutputArcsTo(Place $place) {
		$place = $this->ensureManagedEntity($place);
	
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select($queryBuilder->expr()->count('arc'))
			->from('Workflow\Entity\Arc', 'arc')
			->innerJoin('arc.place', 'place', Join::WITH, $queryBuilder->expr()->eq('place.id', ':placeId'))
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('arc.direction', ':arcDirection'))
			->setParameter('placeId', $place->getId())
			->setParameter('workflowId', $place->getWorkflow()->getId())
			->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
			->getQuery()
			->getSingleScalarResult();
	}
	
	public function getOutputArcsTo(Place $place) {
		$place = $this->ensureManagedEntity($place);
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select(array('arc', 'place', 'transition'))
			->from('Workflow\Entity\Arc', 'arc')
			->innerJoin('arc.transition', 'transition')
			->innerJoin('arc.place', 'place', Join::WITH, $queryBuilder->expr()->eq('place.id', ':placeId'))
			->innerJoin('place.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('arc.direction', ':arcDirection'))
			->setParameter('placeId', $place->getId())
			->setParameter('workflowId', $place->getWorkflow()->getId())
			->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
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