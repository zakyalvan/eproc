<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Workflow;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\UnitOfWork;

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
	 * @return boolean
	 */
	public function isValidWorkflowAttributes($workflow, array $attributes, $throwExceptionOnInvalid = false) {
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$results = $queryBuilder->select('attribute.name')
			->from('Workflow\Entity\WorkflowAttribute', 'attribute')
			->innerJoin('attribute.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->in('attribute.name', ':attributeNames'))
			->setParameter('attributeNames', $attributes)
			->setParameter('workflowId', $workflowId)
			->getQuery()
			->getScalarResult();
		
		
		$registeredAttributes = array();
		foreach ($results as $result) {
			$registeredAttributes[] = $result['name'];
		}
		
		if(count($attributes) != count($registeredAttributes)) {
			if($throwExceptionOnInvalid) {
				throw new \InvalidArgumentException(sprintf('Sebagian atau seluruh attribute yang diberikan tidak valid. Attribut yang diberikan %s sementara atribut yang teregister %s', implode(', ', $attributes), implode(', ', $registeredAttributes)), 100, null);
			}
			return false;
		}
		
		$invalidAttributes = array();
		foreach ($attributes as $attribute) {
			if(!in_array($attribute, $registeredAttributes)) {
				$invalidAttributes[] = $attribute;
			}
		}
		if(count($invalidAttributes) > 0) {
			if($throwExceptionOnInvalid) {
				throw new \InvalidArgumentException(sprintf('Sebagian atau seluruh attribute yang diberikan tidak valid. Attribut yang diberikan yang tidak valid %s', implode(', ', $invalidAttributes)), 100, null);
			}
			return false;
		}
		return true;
	}
	
	/**
	 * Retrieve registered attributes untuk workflow yang diberikan.
	 * 
	 * @param unknown $workflow
	 * @return array
	 */
	public function getWorkflowAttributes($workflow) {
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflow = $this->ensureManagedEntity($workflow);
			$workflowId = $workflow->getId();
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$results = $queryBuilder->select('attribute.name')
			->from('Workflow\Entity\WorkflowAttribute', 'attribute')
			->innerJoin('attribute.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->setParameter('workflowId', $workflowId)
			->getQuery()
			->getScalarResult();
		
		$registeredAttributes = array();
		foreach ($results as $result) {
			$registeredAttributes[] = $result['name'];
		}
		
		return $registeredAttributes;
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