<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Task;
use Doctrine\ORM\UnitOfWork;

/**
 * 
 * @author zakyalvan
 *
 */
class TaskRepository extends EntityRepository {
	/**
	 * 
	 * @param Task $task
	 * @return array
	 */
	public function getTaskParameters(Task $task) {
		$task = $this->ensureManagedEntity($task);
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		$parameters = $queryBuilder->select('param')
			->from('Workflow\Entity\TaskParameter', 'param')
			->innerJoin('param.task', 'task')
			->where($queryBuilder->expr()->eq('task.id', ':taskId'))
			->setParameter('taskId', $task->getId())
			->getQuery()
			->getResult();
		
		$datas = array();
		foreach ($parameters as $parameter) {
			$datas[$parameter->getName()] = $parameter->getValue();
		}
		
		return $datas;
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