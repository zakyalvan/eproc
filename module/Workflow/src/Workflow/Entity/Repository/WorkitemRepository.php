<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Instance;
use Workflow\Entity\Transition;
use Workflow\Entity\Workitem;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\UnitOfWork;

/**
 * Custom repository untuk entity {@link Workitem}
 * 
 * @author zakyalvan
 */
class WorkitemRepository extends EntityRepository {
	/**
	 * Hitung semua workitem yang pernah dibuat pada transition dan instance yang diberikan.
	 * 
	 * @param Instance $instance
	 * @param Transition $transition
	 */
	public function countWorkitem(Instance $instance, Transition $transition) {
 		$instance = $this->ensureManagedEntity($instance);
 		$transition = $this->ensureManagedEntity($transition);
		
 		if($transition->getWorkflow()->getId() !== $instance->getWorkflow()->getId()) {
 			throw new \InvalidArgumentException('Parameter tidak valid. Object transition dan instance bukan dari definisi workflow yang sama', 100, null);
 		}

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select($queryBuilder->expr()->count('workitem'))
			->from('Workflow\Entity\Workitem', 'workitem')
			->innerJoin('workitem.transition', 'transition', Join::WITH, $queryBuilder->expr()->eq('transition.id', ':transitionId'))
			->innerJoin('transition.workflow', 'transitionWorkflow', Join::WITH, $queryBuilder->expr()->eq('transitionWorkflow.id', ':transitionWorkflowId'))
			->innerJoin('workitem.instance', 'inst', Join::WITH, $queryBuilder->expr()->eq('inst.id', ':instanceId'))
			->innerJoin('inst.workflow', 'instanceWorkflow', Join::WITH, $queryBuilder->expr()->eq('instanceWorkflow.id', ':instanceWorkflowId'))
			->setParameter('transitionId', $transition->getId())
			->setParameter('transitionWorkflowId', $transition->getWorkflow()->getId())
			->setParameter('instanceId', $instance->getId())
			->setParameter('instanceWorkflowId', $instance->getWorkflow()->getId())
			->getQuery()
			->getSingleScalarResult();
	}
	
	/**
	 * Apakah ada enabled workitem pada instance dan transition yang diberikan.
	 * 
	 * @param Transition $transition
	 * @param Instance $instance
	 * @throws \InvalidArgumentException
	 * @return boolean
	 */
	public function hasEnabledWorkitem(Instance $instance, Transition $transition) {
		return $this->countEnabledWorkitem($instance, $transition) > 0 ? true : false;
	}
	
	/**
	 * Count workitem yang masih pending atau berstatus enabled.
	 * 
	 * @param Instance $instance
	 * @param Transition $transition
	 * @throws \InvalidArgumentException
	 * @return integer
	 */
	public function countEnabledWorkitem(Instance $instance, Transition $transition) {
		$instance = $this->ensureManagedEntity($instance);
		$transition = $this->ensureManagedEntity($transition);
		
		if($transition->getWorkflow()->getId() !== $instance->getWorkflow()->getId()) {
			throw new \InvalidArgumentException('Parameter tidak valid. Object transition dan instance bukan dari definisi workflow yang sama', 100, null);
		}
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		$workitemCount = $queryBuilder->select($queryBuilder->expr()->count('workitem'))
			->from('Workflow\Entity\Workitem', 'workitem')
			->innerJoin('workitem.transition', 'transition', Join::WITH, $queryBuilder->expr()->eq('transition.id', ':transitionId'))
			->innerJoin('transition.workflow', 'transitionWorkflow', Join::WITH, $queryBuilder->expr()->eq('transitionWorkflow.id', ':transitionWorkflowId'))
			->innerJoin('workitem.instance', 'inst', Join::WITH, $queryBuilder->expr()->eq('inst.id', ':instanceId'))
			->innerJoin('inst.workflow', 'instanceWorkflow', Join::WITH, $queryBuilder->expr()->eq('instanceWorkflow.id', ':instanceWorkflowId'))
			->where($queryBuilder->expr()->eq('workitem.status', ':workitemStatus'))
			->setParameter('transitionId', $transition->getId())
			->setParameter('transitionWorkflowId', $transition->getWorkflow()->getId())
			->setParameter('instanceId', $instance->getId())
			->setParameter('instanceWorkflowId', $instance->getWorkflow()->getId())
			->setParameter('workitemStatus', Workitem::STATUS_ENABLED)
			->getQuery()
			->getSingleScalarResult();
		
		return $workitemCount;
	}
	
	/**
	 * 
	 * @param unknown $workitemId
	 * @param unknown $workflowId
	 * @param unknown $instanceId
	 * @param unknown $transitionId
	 * @return Workitem
	 */
	public function getWorkitem($workitemId, $workflowId, $instanceId, $transitionId) {
		$queryBuilder = $this->_em->createQueryBuilder();
		return $queryBuilder->select(array('workitem', 'transition', 'task', 'transitionWorkflow', 'instance', 'instanceWorkflow'))
			->from('Workflow\Entity\Workitem', 'workitem')
			->innerJoin('workitem.transition', 'transition', Join::WITH, $queryBuilder->expr()->eq('transition.id', ':transitionId'))
			->innerJoin('transition.task', 'task')
			->innerJoin('transition.workflow', 'transitionWorkflow', Join::WITH, $queryBuilder->expr()->eq('transitionWorkflow.id', ':transitionWorkflowId'))
			->innerJoin('workitem.instance', 'inst', Join::WITH, $queryBuilder->expr()->eq('inst.id', ':instanceId'))
			->innerJoin('inst.workflow', 'instanceWorkflow', Join::WITH, $queryBuilder->expr()->eq('instanceWorkflow.id', ':instanceWorkflowId'))
			->where($queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('workitem.id', ':workitemId')
			))
			->setParameter('instanceWorkflowId', $workflowId)
			->setParameter('transitionWorkflowId', $workflowId)
			->setParameter('transitionId', $tra)
			->setParameter('instanceId', $instanceId)
			->setParameter('workitemId', $workitemId)
			->getQuery()
			->getSingleResult();
	}
	
	public function isEnabledWorkitem(Workitem $workitem) {
		return $this->isWorkitemInStatus($workitem, Workitem::STATUS_ENABLED);
	}
	public function isFinishedWorkitem(Workitem $workitem) {
		return $this->isWorkitemInStatus($workitem, Workitem::STATUS_FINISHED);
	}
	public function isCanceledWorkitem(Workitem $workitem) {
		return $this->isWorkitemInStatus($workitem, Workitem::STATUS_CANCELED);
	}
	
	protected function isWorkitemInStatus(Workitem $workitem, $status) {
		return $this->_em->createQuery('SELECT EXISTS(workitem) FROM Workflow\Entity\Workitem workitem INNER JOIN workitem.transition transition WITH transition.id = :transitionId INNER JOIN workitem.instance inst WITH inst.id = :instanceId WHERE workitem.id = :workitemId AND workitem.status :workitemStatus')
			->setParameter('instanceId', $workitem->getInstance()->getId())
			->setParameter('transitionId', $workitem->getTransition()->getId())
			->setParameter('workitemId', $workitem->getId())
			->setParameter('workitemStatus', $status)
			->getSingleScalarResult();
	}
	
	
	
	/**
	 * Apakah user yang diberikan adalah executor yang valid untuk workitem.
	 * 
	 * @param Workitem $workitem
	 * @param string $userId
	 * @param string $userContext
	 */
	public function isValidWorkitemExecutor(Workitem $workitem, $userContext, $userId, $userRole = null) {
		$queryBuilder = $this->_em->createQueryBuilder();
		$queryBuilder->select($queryBuilder->expr()->count('workitem'))
			->from('Workflow\Entity\Workitem', 'workitem');
			
		if($userRole != null) {	
			$queryBuilder->innerJoin('workitem.transition', 'transition', Join::WITH, $queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('transition.userContext', ':userContext'),
				$queryBuilder->expr()->eq('transition.userRole', ':userRole')
			))
				->setParameter('userContext', $userContext)
				->setParameter('userRole', $userRole);
		}
		else {
			$queryBuilder->innerJoin('workitem.transition', 'transition', Join::WITH, $queryBuilder->expr()->eq('transition.userContext', ':userContext'))
				->setParameter('userContext', $userContext);
		}
		
		$queryBuilder->where($queryBuilder->expr()->eq('workitem.executor', ':executorId'))
			->setParameter('executorId', $userId);
		
		$validExecutor = $queryBuilder->getQuery()->getSingleScalarResult();
		
		return $validExecutor > 0 ? true : false;
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