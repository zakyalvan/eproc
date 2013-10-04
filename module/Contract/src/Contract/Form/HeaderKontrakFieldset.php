<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;

/**
 * Fieldset untuk header kontrak.
 * 
 * @author zakyalvan
 */
class HeaderKontrakFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('ContractHeader');
		$this->setHydrator(new ClassMethodsHydrator());
		
		
	}
	
	/**
	 * Input filter spec untuk fieldset.
	 */
	public function getInputFilterSpecification() {
		return array();
	}
}