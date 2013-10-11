<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Instance;
use Workflow\Entity\Transition;
use Workflow\Entity\Workitem;

/**
 * Custom repository untuk entity {@link Workitem}
 * 
 * @author zakyalvan
 */
class WorkitemRepository extends EntityRepository {
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