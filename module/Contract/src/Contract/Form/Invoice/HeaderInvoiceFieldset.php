<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

/**
 * Fieldset header invoice.
 * 
 * @author zakyalvan
 */
class HeaderInvoiceFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('HeaderInvoice');
		$this->setHydrator(new ClassMethodsHydrator());
	}
	
	public function getInputFilterSpecification() {
		return array();
	}
}