<?php
namespace Workflow\Execution;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Workflow\Execution\Router\ProcessRouterInterface as ProcessRouter;
use Workflow\Execution\Router\RouteResult;
use Workflow\Entity\Instance;
use Workflow\Entity\Place;
use Workflow\Entity\Workflow;
use Workflow\Entity\Token;
use Workflow\Entity\WorkflowAttribute;
use Workflow\Entity\InstanceData;
use Application\Common\KeyGeneratorInterface;

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
		
		/* @var $entityManager EntityManager */
		$entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		
		
		
		/* @var $keyGenerator KeyGeneratatorInterface */ 
		$keyGenerator = $this->serviceLocator->get('Application\Common\KeyGeneratator');
		
		// Start transaksi.
		$entityManager->beginTransaction();
		try {
			// Ambil ulang data workflow dari database.
			$persitedWorkflow = $entityManager->createQuery('SELECT workflow FROM Workflow\Entity\Workflow workflow WHERE workflow.id = :workflowId')
				->setParameter('workflowId', $workflow->getId())
				->getOneOrNullResult();
			
			if($persitedWorkflow == null) {
				$workflow = $entityManager->merge($workflow);
			}
			else {
				$workflow = $persitedWorkflow;
			}
			
			
			
			// Pertama create instance.
			$instance = new Instance();
			$instance->setId($keyGenerator->generateNextKey($instance, 'id'));
			$instance->setWorkflow($workflow);
			$instance->setContext('Context');
			$instance->setStatus(Instance::STATUS_OPERATED);
			/**
			 * TODO Set start data untuk instance.
			 */
			
			$entityManager->persist($instance);
			
			// Masukin instance datas.
			foreach ($datas as $key => $value) {
				$workflowAttribute = new WorkflowAttribute();
				$workflowAttribute->setWorkflow($workflow);
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
				
				$entityManager->persist($workflowAttribute);
				
				$instanceData = new InstanceData();
				$instanceData->setInstance($instance);
				$instanceData->setAttribute($workflowAttribute);
				$instanceData->setValue($value);
				
				$entityManager->persist($instanceData);
			}
			
			// Ambil start place dari workflow.
			$startPlace = $entityManager->getRepository('Workflow\Entity\Place')->getStartPlace($workflow->getId());
			
			// Create token pada start place.
			$token = new Token();
			$token->setInstance($instance);
			$token->setPlace($startPlace);
			$token->setStatus(Token::STATUS_FREE);
			
			$entityManager->persist($token);
			
			/* @var $processRouter ProcessRouter */
			$processRouter = $this->serviceLocator->get('Workflow\Execution\Router\ProcessRouter');
			
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
			
			// Commit transaksi.
			$entityManager->commit();
			return $instance;
		}
		catch (\Exception $e) {
			// Rollback transaksi.
			$entityManager->rollback();
			throw new \RuntimeException('Terjadi kesalahan dalam proses start workflow. Silahkan perhatikan trace exception.', 100, $e);
		}
	}
	
	/**
	 * Route token to next place.
	 * 
	 * @param Token $token
	 */
	protected function routeTokenToNextPlace(Token $token) {
		/* @var $processRouter ProcessRouter */
		$processRouter = $this->serviceLocator->get('Workflow\Execution\Router\ProcessRouter');
		
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
			->createQuery('SELECT instance.status FROM Workflow\Entity\Instance instance WHERE instance.id = :instanceId')
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
	}
	
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}