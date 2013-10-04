<?php
namespace Procurement\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

/**
 * Fieldset tender header.
 * 
 * @author zakyalvan
 */
class HeaderTenderFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('TenderHeader');
		$this->setHydrator(new ClassMethodsHydrator());
	}
	
	public function getInputFilterSpecification() {
		return array();
	}
}