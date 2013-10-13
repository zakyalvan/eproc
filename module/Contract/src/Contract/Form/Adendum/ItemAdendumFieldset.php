<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

/**
 * Fieldset item adendum.
 * 
 * @author zakyalvan
 */
class ItemAdendumFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('ItemAdendum');
		$this->setHydrator(new ClassMethodsHydrator());
	}
	
	public function getInputFilterSpecification() {
		return array();
	}
}