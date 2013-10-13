<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

/**
 * Fieldser header adendum.
 * 
 * @author zakyalvan
 */
class HeaderAdendumFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('HeaderAdendum');
		$this->setHydrator(new ClassMethodsHydrator());
	}
	public function getInputFilterSpecification() {
		return array();
	}
}