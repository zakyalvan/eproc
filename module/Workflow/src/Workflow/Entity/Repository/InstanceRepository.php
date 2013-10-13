<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Instance;
use Workflow\Entity\WorkflowAttribute;
use Workflow\Entity\InstanceData;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Custom repository untuk entity Instance
 * 
 * @author zakyalvan
 */
class InstanceRepository extends EntityRepository {
	/**
	 * Retrieve instance data untuk instance yang diberikan.
	 * 
	 * @param Instance $instance
	 * @return multitype:boolean number Ambigous <boolean> Ambigous <boolean, Ambigous <boolean>, number>
	 */
	public function getInstanceDatas(Instance $instance) {
		$queryBuilder = $this->_em->createQueryBuilder();
		$queryBuilder->select('workflowAttribute.name, workflowAttribute.type, instanceData.value')
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
			
			$this->_em->flush();
			$this->_em->commit();
		}
		catch (\Exception $e) {
			$this->_em->rollback();
			throw new \RuntimeException('Simpan data instance data gagal. Silahkan lihat trace exception', 100, $e);
		}
	}
}