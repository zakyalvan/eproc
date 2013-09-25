<?php
namespace Workflow\Execution;

use Workflow\Entity\Workitem;
use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Workflow\Entity\WorkflowAttribute;

class WorkitemManager implements ServiceLocatorAware {
	/**
	 * @var Workitem
	 */
	protected $managed; 
	
	/**
	 * @var ServiceLocator
	 */
	protected $serviceLocator;
	
	/**
	 * @var EntityManager
	 */
	protected $entityManager;
	
	public function setDatas(array $datas) {
		// Masukin instance datas.
		foreach ($datas as $key => $value) {
			$attribute = new WorkflowAttribute();
			$attribute->setName($key);
			if(is_numeric($value) && is_integer($value)) {
				$attribute->setType(WorkflowAttribute::TYPE_INTEGER);
			}
			else if(is_numeric($value) && is_double($value)) {
				$attribute->setType(WorkflowAttribute::TYPE_DOUBLE);
			}
			else if(is_bool($value)) {
				$attribute->setType(WorkflowAttribute::TYPE_BOOLEAN);
			}
			else if(is_string($value)) {
				$attribute->setType(WorkflowAttribute::TYPE_STRING);
			}
			
			$this->entityManager->persist($attribute);
				
			$instanceData = new InstanceData();
			$instanceData->setInstance($instance);
			$instanceData->setAttribute($workflowAttribute);
			$instanceData->setValue($value);
				
			$this->entityManager->persist($instanceData);
		}
		
		return $this;
	}
	public function setFinished() {
		$this->managed->setStatus(Workitem::STATUS_FINISHED);
		return $this;
	}
	public function setCanceled() {
		$this->managed->setStatus(Workitem::STATUS_CANCELED);
		return $this;
	}
	public function setExecutor($executor) {
		
		return $this;
	}
	public function commit() {
		$this->entityManager->flush($this->managed);
	}
	
	public function setManaged(Workitem $managed) {
		$this->managed = $managed;
		if($this->managed->getStatus() == Workitem::STATUS_FINISHED) {
			throw new \InvalidArgumentException("Work item dengan status FINISHED tidak dapat dimanage lagi.", 100, null);
		}
		$this->entityManager->merge($this->managed);
	}
	public function getManaged() {
		return $this->managed;
	}
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
		$this->serviceLocator = $serviceLocator;
	}
	
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}