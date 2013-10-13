<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Instance;
use Workflow\Entity\Transition;
use Workflow\Entity\Workitem;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Custom repository untuk entity {@link Workitem}
 * 
 * @author zakyalvan
 */
class WorkitemRepository extends EntityRepository {
	/**
	 * 
	 * @param unknown $workitemId
	 * @param unknown $workflowId
	 * @param unknown $instanceId
	 * @param unknown $transitionId
	 * @return Workitem
	 */
	public function getWorkitemByIdentity($workitemId, $workflowId, $instanceId, $transitionId) {
		$queryBuilder = $this->_em->createQueryBuilder();
		return $queryBuilder->select(array('workitem', 'transition', 'task', 'transitionWorkflow', 'instance', 'instanceWorkflow'))
			->from('Workflow\Entity\Workitem', 'workitem')
			->innerJoin('workitem.transition', 'transition', Join::WITH, $queryBuilder->expr()->eq('transition.id', ':transitionId'))
			->innerJoin('transition.task', 'task')
			->innerJoin('transition.workflow', 'transitionWorkflow', Join::WITH, $queryBuilder->expr()->eq('transitionWorkflow.id', ':transitionWorkflowId'))
			->innerJoin('workitem.instance', 'instance', Join::WITH, $queryBuilder->expr()->eq('instance.id', ':isntanceId'))
			->innerJoin('instance.workflow', 'instanceWorkflow', Join::WITH, $queryBuilder->expr()->eq('instanceWorkflow.id', ':instanceWorkflowId'))
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
		return $this->_em->createQuery('SELECT EXISTS(workitem) FROM Workflow\Entity\Workitem workitem INNER JOIN workitem.transition transition WITH transition.id = :transitionId INNER JOIN workitem.instance instance WITH instance.id = :instanceId WHERE workitem.id = :workitemId AND workitem.status :workitemStatus')
			->setParameter('instanceId', $workitem->getInstance()->getId())
			->setParameter('transitionId', $workitem->getTransition()->getId())
			->setParameter('workitemId', $workitem->getId())
			->setParameter('workitemStatus', $status)
			->getSingleScalarResult();
	}
	
	/**
	 * Count workitem yang masih pending atau berstatus enabled.
	 * 
	 * @param Instance $instance
	 * @param Transition $transition
	 */
	public function countEnabledWorkitem(Instance $instance, Transition $transition) {
		$validParams = $this->_em->createQuery('SELECT CASE WHEN instance.workflow.id = transition.workflow.id THEN 1 ELSE 0 FROM Workflow\Entity\Workitem workitem INNER JOIN workitem.transition transition WITH transition.id = :transitionId INNER JOIN transition.workflow INNER JOIN workitem.instance instance WITH instance.id = :instanceId INNER JOIN instance.workflow')
			->setParameter('transitionId', $transition->getId())
			->setParameter('instanceId', $instance->getId())
			->getSingleScalarResult();
		
		if($validParams == 0) {
			throw new \InvalidArgumentException('Parameter yang diberikan tidak valid, transition dan instance yang diberikan bukan dari satu workflow yang sama.', 100, null);
		}
		
		return $this->_em->createQuery('SELECT COUNT(workitem) FROM Workflow\Entity\Workitem workitem INNER JOIN workitem.instance instance WITH instance.id = :instanceId INNER JOIN workitem.transition transition WITH transition.id = :transitionId WHERE workitem.status = :workitemStatus')
			->setParameter('instanceId', $instance->getId())
			->setParameter('workflowId', $instance->getWorkflow()->getId())
			->setParameter('transitionId', $transition->getId())
			->setParameter('workitemStatus', Workitem::STATUS_ENABLED)
			->getSingleScalarResult();
	}
}