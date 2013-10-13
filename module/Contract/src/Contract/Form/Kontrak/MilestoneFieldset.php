<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineObjectHydrator;

/**
 * Fieldset untuk milestone kontrak.
 * 
 * @author zakyalvan
 */
class MilestoneFieldset extends Fieldset implements InputFilterProvider {
	CONST DEFAULT_NAME = 'milestoneFieldset';
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function __construct(ServiceLocator $serviceLocator, $name = self::DEFAULT_NAME) {
		parent::__construct($name);
		
		$this->serviceLocator = $serviceLocator;
		
		$objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
		
		//$this->setHydrator(new DoctrineObjectHydrator($objectManager, ''));
		
		
	}
	
	public function getInputFilterSpecification() {
		return array(
			
		);
	}
}