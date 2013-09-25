<?php
namespace Workflow\Execution;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Workflow\Execution\Router\ProcessRouter;
use Workflow\Execution\Router\RouteResult;
use Workflow\Entity\Instance;
use Workflow\Entity\Place;
use Workflow\Entity\Workflow;
use Workflow\Entity\Token;
use Workflow\Entity\WorkflowAttribute;
use Workflow\Entity\InstanceData;

/**
 * Implementasi default dari ExecutionServiceInterface
 * 
 * @author zakyalvan
 */
class ExecutionService implements ExecutionServiceInterface, ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * @var EntityManager
	 */
	private $entityManager;
	
	/**
	 * @var ProcessRouter
	 */
	private $processRouter;
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Manager\InstanceManagerInterface::canStartWorkflow()
	 */
	public function canStartWorkflow(Workflow $workflow, array $datas) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Manager\InstanceManagerInterface::startWorkflow()
	 */
	public function startWorkflow(Workflow $workflow, array $datas) {
		if(!($workflow != null && $workflow->getId() != null)) {
			throw new \InvalidArgumentException('Parameter workflow yang diberikan tidak valid', 100, null);
		}
		
		try {
			// Ambil ulang data workflow dari database.
			$persitedWorkflow = $this->entityManager
				->createQuery('SELECT workflow FROM Workflow\Entity\Workflow AS workflow WHERE workflow.id = :workflowId')
				->setParameter('workflowId', $workflow->getId())
				->getOneOrNullResult();
			
			if($persitedWorkflow == null) {
				$workflow = $this->entityManager->merge($workflow);
			}
			else {
				$workflow = $persitedWorkflow;
			}
			
			// Ambil start place dari workflow.
			$startPlace = $this->entityManager->getRepository('Workflow\Entity\Place')->getStartPlace($workflow->getId());
			
			// Start transaksi.
			$this->entityManager->beginTransaction();
			
			// Pertama create instance.
			$instance = new Instance();
			$instance->setWorkflow($workflow);
			$instance->setContext('Context');
			$instance->setStatus(Instance::STATUS_OPERATED);
			/**
			 * TODO Set start data untuk instance.
			 */
			
			$this->entityManager->persist($instance);
			
			// Masukin instance datas.
			foreach ($datas as $key => $value) {
				$workflowAttribute = new WorkflowAttribute();
				$workflowAttribute->setName($key);
				if(is_numeric($value) && is_integer($value)) {
					$workflowAttribute->setType(WorkflowAttribute::TYPE_INTEGER);
				}
				else if(is_numeric($value) && is_double($value)) {
					$workflowAttribute->setType(WorkflowAttribute::TYPE_DOUBLE);
				}
				else if(is_bool($value)) {
					$workflowAttribute->setType(WorkflowAttribute::TYPE_BOOLEAN);
				}
				else if(is_string($value)) {
					$workflowAttribute->setType(WorkflowAttribute::TYPE_STRING);
				}
				
				$this->entityManager->persist($workflowAttribute);
				
				$instanceData = new InstanceData();
				$instanceData->setInstance($instance);
				$instanceData->setAttribute($workflowAttribute);
				$instanceData->setValue($value);
				
				$this->entityManager->persist($instanceData);
			}
			
			// Create token pada start place.
			$token = new Token();
			$token->setInstance($instance);
			$token->setPlace($startPlace);
			$token->setStatus(Token::STATUS_FREE);
			
			$this->entityManager->persist($token);
			
			$routeSuccess = true;
			$tokenToRoute = $token;

			// Sekarang waktunya route token sampain proses routing gagal/berhenti.
			while($routeSuccess) {
				$result = $this->processRouter->routeToNextPlace($tokenToRoute);
				
				if($result->isSuccess()) {
					$nextTokensCount = count($result->getNextTokens());
					if($nextTokensCount == 1) {
						$nextTokens = $result->getNextTokens();
						$tokenToRoute = $nextTokens[0];
					}
					else if($nextTokensCount < 1) {
						throw new \RuntimeException("Jumlah proses next token setelah proses routing == 1, ini aneh.", 0, null);
					}
					else if($nextTokensCount > 1) {
						throw new \RuntimeException("Belum bisa handle percabangan pada transisi (dua free token pada satu instance setelah proses routing)");
					}
				}
				else {
					$routeSuccess = false;
					if($result->getCode() == RouteResult::EXCEPTION_ON_ROUTING_CODE) {
						// Lempar kembali exception dari proses routing.
						throw $result->getException();
					}
				}
			}
			
			// Flush seluruh perubahan.
			$this->entityManager->flush();
			
			// Commit transaksi.
			$this->entityManager->commit();
			
			return $instance;
		}
		catch (\Exception $e) {
			// Rollback transaksi.
			$this->entityManager->rollback();
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\ExecutionServiceInterface::manageWorkitem()
	 */
	public function manageWorkitem(Workitem $workitem) {
		$manager = $this->serviceLocator->get('Workflow\Execution\WorkitemManager');
		$manager->setManaged($workitem);
		return $manager;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Execution\ExecutionServiceInterface::isCompletedInstance()
	 */
	public function isCompletedInstance(Instance $instance) {
		$status = $this->entityManager
			->createQuery('SELECT instance.status FROM Workflow\Entity\Instance AS instance WHERE instance.id = :instanceId')
			->setParameter('instanceId', $instance->getId())
			->getScalarResult();
		
		if($status == Instance::STATUS_FINISHED) {
			return true;
		}
		return false;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Workflow\Manager\InstanceManagerInterface::getWorkflowState()
	 */
	public function getInstanceState(Instance $instance) {
		return $this->entityManager
			->createQuery('SELECT token.place FROM Workflow\Entity\Token AS token INNER JOIN token.place INNER JOIN token.instance WITH token.instance.id = :instanceId')
			->setParameter('instanceId', $instance->getId())
			->getResult();
	}
	
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
		
		if($this->entityManager == null) {
			$this->entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		}
		if($this->processRouter == null) {
			$this->processRouter = $this->serviceLocator->get('Workflow\Execution\Router\ProcessRouter');
		}
	}
	
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}