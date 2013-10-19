<?php
namespace Contract\Todo;

use Application\Todo\AbstractTodoListProvider;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Workflow\Entity\Instance;
use Workflow\Entity\Workitem;
use Workflow\Entity\UserTransition;
use Workflow\Entity\Repository\WorkitemRepository;
use Workflow\Entity\Repository\InstanceRepository;
use Application\Common\AbstractDumbTodoListProvider;
use Procurement\Entity\Tender\Repository\TenderRepository;
use Vendor\Entity\Vendor;
use Procurement\Entity\Tender\Tender;
use Workflow\Entity\Repository\PlaceRepository;
use Workflow\Entity\Repository\TaskRepository;

/**
 * Todo list provider untuk proses manajemen kontrak.
 * 
 * @author zakyalvan
 */
class ContractCreateTodoListProvider extends AbstractDumbTodoListProvider {
	const KODE_ROLE_CONTEXT_KEY = 'kodeRole';
	const KODE_KANTOR_CONTEXT_KEY = 'kodeKantor';
	const KODE_USER_CONTEXT_KEY = 'kodeUser';
	
	const PEMBUATAN_KONTRAK_WORKFLOW_ID = 'PEMBUATAN_KONTRAK';
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::init()
	 */
	public function init() {
		$this->requiredContextDataKeys = array(self::KODE_ROLE_CONTEXT_KEY, self::KODE_KANTOR_CONTEXT_KEY, self::KODE_USER_CONTEXT_KEY);
	}
	
	protected function buildArrayOfObject(EntityManager $entityManager) {
		$workflowRepository = $entityManager->getRepository('Workflow\Entity\Workflow');
		$workflow = $workflowRepository->find(self::PEMBUATAN_KONTRAK_WORKFLOW_ID);
		
		/* @var $workitemRepository WorkitemRepository */
		$workitemRepository = $entityManager->getRepository('Workflow\Entity\Workitem');
		$workitems = $workitemRepository->getEnabledWorkitemsForUser($workflow, 'INTERNAL', $this->contexDatas[self::KODE_ROLE_CONTEXT_KEY], $this->contexDatas[self::KODE_USER_CONTEXT_KEY]);
		
		
		/* @var $instanceRepository InstanceRepository */
		$instanceRepository = $entityManager->getRepository('Workflow\Entity\Instance');
		
		$todoItemArray = array();
		
		/* @var $workitem Workitem */
		foreach ($workitems as $index => $workitem) {
			$instanceDatas = $instanceRepository->getInstanceDatas($workitem->getInstance());
			
			/* @var $queryBuilder QueryBuilder */ 
			$queryBuilder = $entityManager->createQueryBuilder();
			
			/* @var $tender Tender */
			$tender = $queryBuilder->select(array('tender', 'kantor'))
				->from('Procurement\Entity\Tender\Tender', 'tender')
				->innerJoin('tender.kantor', 'kantor')
				->orWhere($queryBuilder->expr()->andX(
					$queryBuilder->expr()->eq('tender.kode', sprintf(':kodeTender', $index)),
					$queryBuilder->expr()->eq('kantor.kode', sprintf(':kodeKantor', $index))
				))
				->setParameter('kodeTender', $instanceDatas['KODE_TENDER'])
				->setParameter('kodeKantor', $instanceDatas['KODE_KANTOR'])
				->getQuery()
				->getSingleResult();
			
			/* @var $tenderRepository TenderRepository */
			$tenderRepository = $entityManager->getRepository('Procurement\Entity\Tender\Tender');
			
			/* @var $vendor Vendor */ 
			$vendor = $tenderRepository->getTenderWinner($tender);
			
			$transition = $workitem->getTransition();
			$task = $transition->getTask();
			
			/* @var $taskRepository TaskRepository */ 
			$taskRepository = $entityManager->getRepository('Workflow\Entity\Task');
			
			$todoItem = new ContractCreateTodoItem(
				$tender->getKode(), 
				$tender->getKantor()->getKode(), 
				$tender->getJudulPekerjaan(), 
				$vendor->getKode(), 
				$vendor->getNama(), 
				$transition->getName(),
				$workitem->getEnabledDate(),
				$task->getAddress(),
				$taskRepository->getTaskParameters($task)
			);
			$todoItemArray[] = $todoItem;
		}
		return $todoItemArray;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Application\Common\AbstractListProvider::buildQuery()
	 */
	protected function buildQuery(QueryBuilder $queryBuilder, $contextDatas = array(), $criterias = array()) {
		/* @var $entityManager EntityManager */ 
		$entityManager = $queryBuilder->getEntityManager();
		
		$workflowRepository = $entityManager->getRepository('Workflow\Entity\Workflow');
		$workflow = $workflowRepository->find(self::PEMBUATAN_KONTRAK_WORKFLOW_ID);
		
		/* @var $workitemRepository WorkitemRepository */ 
		$workitemRepository = $entityManager->getRepository('Workflow\Entity\Workitem');
		$workitems = $workitemRepository->getEnabledWorkitemsForUser($workflow, 'INTERNAL', $this->contexDatas[self::KODE_ROLE_CONTEXT_KEY], $this->contexDatas[self::KODE_USER_CONTEXT_KEY]);
		$queryBuilder->select(array('tender', 'kantor'))
			->from('Procurement\Entity\Tender\Tender', 'tender')
			->innerJoin('tender.kantor', 'kantor');
		
		/* @var $instanceRepository InstanceRepository */
		$instanceRepository = $entityManager->getRepository('Workflow\Entity\Instance');
		
		/* @var $workitem Workitem */
		foreach ($workitems as $index => $workitem) {
			$instanceDatas = $instanceRepository->getInstanceDatas($workitem->getInstance());
			$queryBuilder->orWhere($queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('tender.kode', sprintf(':kodeTender%s', $index)),
				$queryBuilder->expr()->eq('kantor.kode', sprintf(':kodeKantor%s', $index))
			))
			->setParameter(sprintf('kodeTender%s', $index), $instanceDatas['KODE_TENDER'])
			->setParameter(sprintf('kodeKantor%s', $index), $instanceDatas['KODE_KANTOR']);
		}
		
		return $queryBuilder;
	}
}