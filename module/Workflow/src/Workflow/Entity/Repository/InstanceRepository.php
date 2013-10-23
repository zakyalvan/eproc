<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Instance;
use Workflow\Entity\WorkflowAttribute;
use Workflow\Entity\InstanceData;
use Doctrine\ORM\Query\Expr\Join;
use Workflow\Entity\Workflow;
use Doctrine\ORM\UnitOfWork;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Custom repository untuk entity Instance
 * 
 * @author zakyalvan
 */
class InstanceRepository extends EntityRepository {
	/**
	 * 
	 * @param unknown $workflow
	 * @param unknown $datas
	 * @return array
	 */
	public function getActiveInstances($workflow, $datas = array()) {
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflow = $this->ensureManagedEntity($workflow);
			$workflowId = $workflow->getId();
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$queryBuilder->select(array('inst'))
			->from('Workflow\Entity\Instance', 'inst')
			->innerJoin('inst.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->innerJoin('inst.datas', 'datas')
			->innerJoin('datas.attribute', 'workflowAttribute');
		
		$index = 1;
		foreach($datas as $name => $value) {
			$queryBuilder->andWhere($queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('workflowAttribute.name', sprintf(':name_%d', $index)),
				$queryBuilder->expr()->eq('datas.value', sprintf(':value_%d', $index))
			));
			
			$queryBuilder->setParameter(sprintf('name_%d', $index), $name);
			$queryBuilder->setParameter(sprintf('value_%d', $index), $value);
			
			$index += 1;
		}
		
		$instances = $queryBuilder
			->setParameter('workflowId', $workflowId)
			->getQuery()
			->getResult();
		
		return $instances;
	}
	
	/**
	 * Apakah sebuah instance sudah beres atau belum.
	 * 
	 * @param unknown $instance
	 * @param unknown $workflow
	 * @throws \InvalidArgumentException
	 * @return boolean
	 */
	public function isFinishedInstance($instance, $workflow) {
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}
		
		$instanceId = $instance;
		if($instance instanceof Instance) {
			$instanceId = $instance->getId();
			
			if($instance->getWorkflow() != null) {
				if($instance->getWorkflow()->getId() != null && $instance->getWorkflow()->getId() != $workflowId) {
					throw new \InvalidArgumentException('Instance bukan eksekusi proses workflow yang diberikan', 100, null);
				}
			}
		}
		
		if($instanceId == null || $workflowId == null) {
			throw new \InvalidArgumentException('Parameter instance dan workflow yang diberikan tidak valid', 100, null);
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$status = $queryBuilder->select('inst.status')
			->from('Workflow\Entity\Instance', 'inst')
			->innerJoin('inst.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('inst.id', ':instanceId'))
			->setParameter('workflowId', $workflowId)
			->setParameter('instanceId', $instanceId)
			->getQuery()
			->getSingleScalarResult();
		
		if($status == Instance::STATUS_FINISHED) {
			return true;
		}
		return false;
	}
	
	/**
	 * Retrieve instance data untuk instance yang diberikan.
	 * 
	 * @param Instance $instance
	 * @return multitype:boolean number Ambigous <boolean> Ambigous <boolean, Ambigous <boolean>, number>
	 */
	public function getInstanceDatas(Instance $instance) {
		$instance = $this->ensureManagedEntity($instance);
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$tempDatas = $queryBuilder->select(array('workflowAttribute.name', 'workflowAttribute.type', 'instanceData.value'))
			->from('Workflow\Entity\InstanceData', 'instanceData')
			->innerJoin('instanceData.instance', 'inst', Join::WITH, $queryBuilder->expr()->eq('inst.id', ':instanceId'))
			->innerJoin('instanceData.attribute', 'workflowAttribute')
			->setParameter('instanceId', $instance->getId())
			//->setParameter('workflowId', $instance->getWorkflow()->getId())
			->getQuery()
			->getArrayResult();
		
		$datas = array();
		foreach ($tempDatas as $tempData) {
			if($tempData['type'] == null)  {
				$tempData['type'] = WorkflowAttribute::TYPE_STRING;
			}

			/**
			 * TODO Parsing data sesuai dengan typenya.
			 */
			if($tempData['type'] == WorkflowAttribute::TYPE_BOOLEAN) {
				$datas[$tempData['name']] = (bool) $tempData['value'];
			}
			else if($tempData['type'] == WorkflowAttribute::TYPE_STRING) {
				$datas[$tempData['name']] = $tempData['value'];
			}
			if($tempData['type'] == WorkflowAttribute::TYPE_INTEGER) {
				$datas[$tempData['name']] = (int) $tempData['value'];
			}
			if($tempData['type'] == WorkflowAttribute::TYPE_DOUBLE) {
				$datas[$tempData['name']] = (float) $tempData['value'];
			}
			if($tempData['type'] == WorkflowAttribute::TYPE_DATE) {
				$datas[$tempData['name']] = $tempData['value'];
			}
		}
		return $datas;
	}
	
	/**
	 * Set instance data.
	 * 
	 * @param Instance $instance
	 * @param array $datas
	 * @throws \RuntimeException
	 */
	public function setInstanceDatas(Instance $instance, array $datas) {
		$attrQueryBuilder = $this->_em->createQueryBuilder();
		
		$attributes = $attrQueryBuilder->select('workflowAttribute')
			->from('Workflow\Entity\WorkflowAttribute', 'workflowAttribute')
			->where($attrQueryBuilder->expr()->in('workflowAttribute.name', ':attributeNames'))
			->setParameter('attributeNames', array_keys($datas))
			->getQuery()
			->getResult();
		
		$this->_em->beginTransaction();
		try {
			foreach ($attributes as $attribute) {
				$instanceData = new InstanceData();
				$instanceData->setAttribute($attribute);
				$instanceData->setValue($datas[$attribute->getName()]);
				$instanceData->setInstance($instance);
				
				$this->_em->persist($instanceData);
			}

			$this->_em->commit();
		}
		catch (\Exception $e) {
			$this->_em->rollback();
			throw new \RuntimeException('Simpan data instance data gagal. Silahkan lihat trace exception', 100, $e);
		}
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