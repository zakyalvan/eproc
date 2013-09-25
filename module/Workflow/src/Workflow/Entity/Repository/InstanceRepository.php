<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Instance;
use Workflow\Entity\WorkflowAttribute;

/**
 * Custom repository untuk entity Instance
 * 
 * @author zakyalvan
 */
class InstanceRepository extends EntityRepository {
	public function getDatasAsArray(Instance $instance) {
		$tempDatas = $this->_em->createQuery('SELECT instance.datas.attribute.name, instance.datas.attribute.type, instance.datas.value FROM Workflow\Entity\Instance instance INNER JOIN instance.datas INNER JOIN instance.datas.attribute WITH instance.datas.attribute.workflow.id = :workflowId WHERE instance.id = :instanceId')
			->setParameter('instanceId', $instance->getId())
			->setParameter('workflowId', $instance->getWorkflow()->getId())
			->getArrayResult();
		
		$datas = array();
		foreach ($tempDatas as $tempData) {
			if($tempData['type'] == null) 
				$tempData['type'] = WorkflowAttribute::TYPE_STRING;
			
			/**
			 * TODO Parsing data sesuai dengan typenya.
			 */
			if($tempData['type'] == WorkflowAttribute::TYPE_BOOLEAN) {
				$datas[$tempData['name']] = $datas[$tempData['value']];
			}
			else if($tempData['type'] == WorkflowAttribute::TYPE_STRING) {
				$datas[$tempData['name']] = $datas[$tempData['value']];
			}
			if($tempData['type'] == WorkflowAttribute::TYPE_INTEGER) {
				$datas[$tempData['name']] = $datas[$tempData['value']];
			}
			if($tempData['type'] == WorkflowAttribute::TYPE_DOUBLE) {
				$datas[$tempData['name']] = $datas[$tempData['value']];
			}
			if($tempData['type'] == WorkflowAttribute::TYPE_DATE) {
				$datas[$tempData['name']] = $datas[$tempData['value']];
			}
		}
		
		return $datas;
	}
	
	public function setDatasAsArray(array $datas) {
		
	}
}