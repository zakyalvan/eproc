<?php
namespace Workflow\Execution\Evaluator\Service;

use Zend\ServiceManager\FactoryInterface as Factory;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Workflow\Execution\Evaluator\SplitEvaluatorRegistry;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;

/**
 * Factory untuk split evaluator registry.
 * Agar split evaluato registry bisa outomatis dipopulate, dalam konfigurasi modul harus ada
 * item konfigurasi 
 * array(
 * 		'workflow' => array(
 * 			'split_evaluators' => array(
 * 				'NAMA/ALIAS SPLIT EVALUATOR' => 'FQCN Split Evaluator'	
 * 			)
 * 		)
 * )
 * 
 * @author zakyalvan
 */
class SplitEvaluatorRegistryFactory implements Factory {
	const DEFAULT_REGISTRY_CONFIG_KEY = 'split_evaluators';
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(ServiceLocator $serviceLocator) {
		$config = $serviceLocator->get('Config');
		
		$splitEvaluatorRegistry = new SplitEvaluatorRegistry();
		if(isset($config['workflow']['split_evaluators'])) {
			try {
				foreach ($config['workflow'][self::DEFAULT_REGISTRY_CONFIG_KEY] as $name => $evaluator) {
					$splitEvaluatorRegistry->add($name, $evaluator);
				}
			}
			catch(\Exception $e) {
				throw new ServiceNotCreatedException("Create object split evalutor registry gagal, eksepsi terjadi", 100, $e);
			}
		}
		
		return $splitEvaluatorRegistry;
	}
}