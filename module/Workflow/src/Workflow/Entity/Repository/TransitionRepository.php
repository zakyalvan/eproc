<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Transition;
use Workflow\Entity\Workflow;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\AbstractQuery;
use Workflow\Entity\UserTransition;
use Workflow\Entity\MesgTransition;
use Workflow\Entity\TimeTransition;
use Workflow\Entity\AutoTransition;
use Doctrine\ORM\UnitOfWork;

/**
 * Custom repository untuk entity {@link Transition}.
 * 
 * @author zakyalvan
 */
class TransitionRepository extends EntityRepository {
	/**
	 * 
	 * @param Workflow $workflow
	 * @param string $type
	 * @param bool $returnParent
	 * @throws \InvalidArgumentException
	 */
	public function getTransitionsByTriggerType(Workflow $workflow, $type, $returnParent = true) {
		$typeTemp = ucfirst(strtolower($type));
		$classType = "Workflow\Entity\{$typeTemp}Transition";
		
		if(!class_exists($classType, true)) {
			throw new \InvalidArgumentException(sprintf('Kelas transition (%s) untuk type %s tidak ditemukan.', $classType, $type), 100, null);
		}
		
		if($returnParent) {
			return $this->_em->createQuery('SELECT transition FROM Workflow\Entity\Transition transition INNER JOIN transition.workflow WITH transition.workflow.id = :workflowId WHERE transition INSTANCE OF :classType')
				->setParameter('classType', $classType)
				->setParameter('workflowId', $workflow->getId())
				->getResult();
		}
		else {
			return $this->_em->createQuery("SELECT transition FROM  {$classType} transition INNER JOIN transition.workflow WITH transition.workflow.id = :workflowId")
				->setParameter('workflowId', $workflow->getId())
				->getResult();
		}
	}
	
	/**
	 * 
	 * 
	 * @param Transition $transition
	 * @return string
	 */
	public function getTransitionTriggerType(Transition $transition) {
		$transition = $this->ensureManagedEntity($transition);
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		$triggerType = $queryBuilder->select("CASE WHEN transition INSTANCE OF Workflow\Entity\UserTransition THEN 'USER' WHEN transition INSTANCE OF Workflow\Entity\MesgTransition THEN 'MESG' WHEN transition INSTANCE OF Workflow\Entity\TimeTransition THEN 'TIME' WHEN transition INSTANCE OF Workflow\Entity\AutoTransition THEN 'AUTO' ELSE 'NONE' END")
			->from('Workflow\Entity\Transition', 'transition')
			->innerJoin('transition.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('transition.id', ':transitionId'))
			->setParameter('workflowId', $transition->getWorkflow()->getId())
			->setParameter('transitionId', $transition->getId())
			->getQuery()
			->getSingleScalarResult();
		return $triggerType;
	}
	
	/**
	 * Retrieve workflow attribute yang menjadi attribute dari sebuah transisi.
	 * 
	 * @param mixed $transition
	 * @return array
	 */
	public function getTransitionAttributes($transition, $workflow) {
		$transitionId = $transition;
		if($transition instanceof Transition) {
			$transitionId = $transition->getId();
		}
		
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$queryBuilder->select('workflowAttribute.name')
			->from('Workflow\Entity\TransitionAttribute', 'transitionAttribute')
			->innerJoin('transitionAttribute.transition', 'transition', Join::WITH, $queryBuilder->expr()->eq('transition.id', ':transitionId'))
			->innerJoin('transition.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->innerJoin('transition.workflowAttribute', 'workflowAttribute')
			->setParameter('transitionId', $transition)
			->setParameter('workflowId', $workflowId)
			->getQuery()
			->getScalarResult();
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