<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Instance;
use Workflow\Entity\WorkflowAttribute;
use Workflow\Entity\InstanceData;
use Doctrine\ORM\Query\Expr\Join;
use Workflow\Entity\Workflow;

/**
 * Custom repository untuk entity Instance
 * 
 * @author zakyalvan
 */
class InstanceRepository extends EntityRepository {
	/**
	 * Create new instance.
	 * 
	 * @param mixed $workflow
	 * @param integer $id
	 * @return Instance
	 */
	public function createNewInstance($workflow) {
		$instance = new Instance();
		$instance->setWorkflow($workflow);
		$instance->setContext('Context');
		$instance->setStatus(Instance::STATUS_OPERATED);
		$instance->setStartDate(new \DateTime(null, null));
		return $this->_em->merge($instance);
	}
	
	public function getActiveInstances($workflow, $datas = array()) {
		$workflowId = $workflow;
		if($workflow instanceof Workflow) {
			$workflowId = $workflow->getId();
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$queryBuilder->select(array('instance'))
			->from('Workflow\Entity\Instance', 'instance')
			->innerJoin('instance.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->innerJoin('instance.datas', 'datas')
			->innerJoin('datas.attribute', 'workflowAttribute');
		
		foreach($datas as $name => $value) {
			$queryBuilder->andWhere($queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('workflowAttribute.name', $name),
				$queryBuilder->expr()->eq('datas.value', $value)
			));
		}
		
		//
		
		return $queryBuilder
			->setParameter('workflowId', $workflowId)
			->getQuery()->getResult();
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
					throw new \InvalidArgumentException('', 100, null);
				}
			}
		}
		
		if($instanceId == null || $workflowId == null) {
			throw new \InvalidArgumentException('Parameter instance dan workflow yang diberikan tidak valid', 100, null);
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$status = $queryBuilder->select('instance.status')
			->from('Workflow\Entity\Instance', 'instance')
			->innerJoin('instance.workflow', 'workflow', Join::WITH, $queryBuilder->expr()->eq('workflow.id', ':workflowId'))
			->where($queryBuilder->expr()->eq('instance.id', ':instanceId'))
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
		$queryBuilder = $this->_em->createQueryBuilder();
		$tempDatas = $queryBuilder->select(array('workflowAttribute.name', 'workflowAttribute.type', 'instanceData.value'))
			->from('Workflow\Entity\InstanceData', 'instanceData')
			->innerJoin('instanceData.instance', 'instance', Join::WITH, $queryBuilder->expr()->eq('instance', ':instance'))
			->innerJoin('instanceData.workflowAttribute', 'workflowAttribute')
			->setParameter('instanceId', $instance->getId())
			->setParameter('workflowId', $instance->getWorkflow()->getId())
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
				$datas[$tempData['name']] = (bool) $datas[$tempData['value']];
			}
			else if($tempData['type'] == WorkflowAttribute::TYPE_STRING) {
				$datas[$tempData['name']] = $datas[$tempData['value']];
			}
			if($tempData['type'] == WorkflowAttribute::TYPE_INTEGER) {
				$datas[$tempData['name']] = (int) $datas[$tempData['value']];
			}
			if($tempData['type'] == WorkflowAttribute::TYPE_DOUBLE) {
				$datas[$tempData['name']] = (float) $datas[$tempData['value']];
			}
			if($tempData['type'] == WorkflowAttribute::TYPE_DATE) {
				$datas[$tempData['name']] = $datas[$tempData['value']];
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
}