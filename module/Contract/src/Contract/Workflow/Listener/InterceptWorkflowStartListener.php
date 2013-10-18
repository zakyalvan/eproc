<?php
namespace Contract\Workflow\Listener;

use Zend\EventManager\ListenerAggregateInterface as ListenerAggregate;
use Zend\EventManager\EventManagerInterface as EventManager;
use Zend\EventManager\SharedEventManagerInterface;
use Workflow\Execution\Event\WorkflowStartEvent;
use Workflow\Execution\ExecutionServiceInterface;

/**
 * Listener untuk event workflow start.
 * 
 * @author zakyalvan
 */
class InterceptWorkflowStartListener implements ListenerAggregate {
	const CREATE_CONTRACT_WORKFLOW_ID = 'PEMBUATAN_KONTRAK';
	const WORK_ORDER_WORKFLOW_ID = 'WORK_ORDER';
	const LUMSUM_SERVICE_WORKFLOW_ID = 'LUMPSUM';
	const INVOICE_PAYMENT_WORKFLOW_ID = 'INVOICE_KONTRAK';
	
	public function attach(EventManager $events, $priority = 2) {
		/* @var $sharedEvents SharedEventManagerInterface */
		$sharedEvents = $events->getSharedManager();
		$this->listeners[] = $sharedEvents->attach('Workflow\Execution\ExecutionService', WorkflowStartEvent::WORKFLOW_PRE_START, array($this, 'onBeforeWorkflowStart'));
	}
	
	public function detach(EventManager $events) {
		foreach ($this->listeners as $index => $listener) {
			if ($events->detach($listener)) {
				unset($this->listeners[$index]);
			}
		}
	}
	
	/**
	 * Dieksekusi sebelum sebuah workflow dimulai.
	 * Digunakan untuk validasi workflow apakah valid untuk dimulai atau tidak.
	 * 
	 * @param WorkflowStartEvent $event
	 */
	public function onBeforeWorkflowStart(WorkflowStartEvent $event) {
		$workflowId = $event->getWorkflow()->getId();
		if($workflowId == self::CREATE_CONTRACT_WORKFLOW_ID) {
			/* @var $executionService ExecutionServiceInterface */ 
			$executionService = $event->getTarget();
			$activeInstances = $executionService->getActiveInstances($event->getWorkflow(), $event->getStartDatas());
			
			if(count($activeInstances) > 0) {
				$event->setAllowResume(false);
				$event->setMessage(sprintf('Proses dengan id workflow id %s dan start instance data %s tidak dapat dimulai, sudah pernah dimulai sebelumnya.', $event->getWorkflow()->getId(), json_encode($event->getStartDatas())));
			}
		}
		else if($workflowId == '') {
			
		}
	}
}