<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Transition;
use Workflow\Entity\Workflow;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\AbstractQuery;

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
	
	public function getTransitionTriggerType($transition) {
		
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
}