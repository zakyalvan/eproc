<?php
namespace Contract\Form;

use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

/**
 * Form untuk pembuatan kontrak.
 * 
 * @author zakyalvan
 */
class CreateContractForm extends Form {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function __construct(ServiceLocator $serviceLocator) {
		parent::__construct('CreateContract');
		
		if($serviceLocator == null) {
			throw new \InvalidArgumentException('Parameter service-locator harus diberikan, null diberikan', 100, null);
		}
		
		
	}
}