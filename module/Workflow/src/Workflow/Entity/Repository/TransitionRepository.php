<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Transition;
use Workflow\Entity\Workflow;

/**
 * Custom repository untuk entity {@link Transition}.
 * 
 * @author zakyalvan
 */
class TransitionRepository extends EntityRepository {
	public function getTransitionsByType(Workflow $workflow, $type, $returnParent = true) {
		$typeTemp = ucfirst(strtolower($type));
		$classType = "Workflow\Entity\{$typeTemp}Transition";
		
		if(!class_exists($classType, true)) {
			throw new \InvalidArgumentException("Kelas transition untuk type ({$type}) tidak ditemukan.", 100, null);
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
	
	public function getTransitionType($transition) {
		
	}
}