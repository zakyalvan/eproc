<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Workflow;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Custom repository untuk entity workflow.
 * 
 * @author zakyalvan
 */
class WorkflowRepository extends EntityRepository {
	/**
	 * Apakah attributes yang diberikan valid atau tidak.
	 * 
	 * @param array $attributes
	 */
	public function isValidWorkflowAttributes($workflow, array $attributes, $throwExceptionOnInvalid = false) {
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$registeredAttributes = $queryBuilder->select('attribute.name')
			->from('Workflow\Entity\WorkflowAttribute', 'attribute')
			->innerJoin('attribute.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->in('attribute.name', ':attributeNames'))
			->setParameter('attributeNames', $attributes)
			->getQuery()
			->getScalarResult();
		
		if(count($attributes) != count($registeredAttributes)) {
			if($throwExceptionOnInvalid) {
				throw new \InvalidArgumentException(sprintf('Sebagian atau seluruh attribute yang diberikan tidak valid. Attribut yang diberikan %s sementara atribut yang teregister %s', implode(', ', $attributes), implode(', ', $registeredAttributes)), 100, null);
			}
			return false;
		}
		return true;
	}
	
	/**
	 * Retrieve registered attributes untuk workflow yang diberikan.
	 * 
	 * @param unknown $workflow
	 * @return Ambigous <multitype:, \Doctrine\ORM\mixed, mixed, \Doctrine\DBAL\Driver\Statement, \Doctrine\Common\Cache\mixed>
	 */
	public function getWorkflowAttributes($workflow) {
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$registeredAttributes = $queryBuilder->select('attribute.name')
			->from('Workflow\Entity\WorkflowAttribute', 'attribute')
			->innerJoin('attribute.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->in('attribute.name', ':attributeNames'))
			->setParameter('attributeNames', $attributes)
			->getQuery()
			->getScalarResult();
		
		return $registeredAttributes;
	}
}