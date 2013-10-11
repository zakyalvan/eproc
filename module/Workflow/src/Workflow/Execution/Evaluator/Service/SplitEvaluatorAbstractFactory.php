<?php
namespace Workflow\Execution\Evaluator\Service;

use Zend\ServiceManager\AbstractFactoryInterface as AbstractFactory;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Workflow\Execution\Evaluator\SplitEvaluatorRegistry;
use Workflow\Execution\Evaluator\ClosureSplitEvaluator;
use Workflow\Execution\Handler\TransitionHandlerRegistry;
use Workflow\Execution\Evaluator\CallbackSplitEvaluator;

/**
 * Kelas abstract factory untuk object kelas yang mengimplement SplitEvalutorInterface.
 * Kelas ini harus didaftarkan dalam object service manager.
 * 
 * @author zakyalvan
 */
class SplitEvaluatorAbstractFactory implements AbstractFactory {
	/**
	 * @var SplitEvaluatorRegistry 
	 */
	private $evaluatorRegistry;
	
	public function canCreateServiceWithName(ServiceLocator $serviceLocator, $name, $requestedName) {
		if($this->evaluatorRegistry == null) {
			$config = $serviceLocator->get('Config');
			$this->evaluatorRegistry = new SplitEvaluatorRegistry();
				
			if(isset($config['workflow'][SplitEvaluatorRegistryFactory::DEFAULT_REGISTRY_CONFIG_KEY])) {
				foreach ($config['workflow'][SplitEvaluatorRegistryFactory::DEFAULT_REGISTRY_CONFIG_KEY] as $alias => $evaluator) {
					$this->evaluatorRegistry->add($alias, $evaluator);
				}
			}
		}
		return $this->evaluatorRegistry->has($requestedName);
	}
	
	public function createServiceWithName(ServiceLocator $serviceLocator, $name, $requestedName) {
		if(!$this->canCreateServiceWithName($serviceLocator, $name, $requestedName)) {
			throw new ServiceNotCreatedException("Object split evaluator dengan nama {$requestedName} tidak dapat dicrete (tidak ditemukan dalam registry)", 0, null);
		}
		
		$evaluator = $this->evaluatorRegistry->get($requestedName);
		if($evaluator instanceof  \Closure || is_callable($evaluator)) {
			return new CallbackSplitEvaluator($evaluator);
		}
		else {
			return new $evaluator();
		}
	}
}