<?php
namespace Workflow\Execution\Evaluator\Service;

use Zend\ServiceManager\AbstractFactoryInterface as AbstractFactory;
use Workflow\Execution\Evaluator\SplitEvaluatorRegistry;

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
	private $evaluatorRegistry = null;
	
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		if($this->evaluatorRegistry == null) {
			if($serviceLocator->has('Workflow\Execution\Evaluator\SplitEvaluatorRegistry')) {
				$this->evaluatorRegistry = $serviceLocator->get('Workflow\Execution\Evaluator\SplitEvaluatorRegistry');
			}
			else {
				$config = $serviceLocator->get('Config');
				$this->evaluatorRegistry = new TransitionHandlerRegistry();
				
				if(isset($config['workflow']['split_evaluators'])) {
					foreach ($config['workflow'][SplitEvaluatorRegistryFactory::DEFAULT_REGISTRY_CONFIG_KEY] as $alias => $evaluator) {
						$this->evaluatorRegistry->add($alias, $evaluator);
					}
				}
			}
		}
		
		return $this->evaluatorRegistry->has($requestedName);
	}
	
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		if(!$this->canCreateServiceWithName($serviceLocator, $name, $requestedName)) {
			throw new ServiceNotCreatedException("Object split evaluator dengan nama {$requestedName} tidak dapat dicrete (tidak ditemukan dalam registry)", 0, null);
		}
		
		$class = $this->evaluatorRegistry->get($requestedName);
		return new $class();
	}
}