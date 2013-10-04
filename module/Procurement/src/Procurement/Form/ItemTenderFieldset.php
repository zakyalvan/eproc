<?php
namespace Procurement\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydarator;

/**
 * Tender item fieldset.
 * 
 * @author zakyalvan
 */
class ItemTenderFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('TenderItem');
		$this->setHydrator(new ClassMethodsHydrator());
	}
	
	public function getInputFilterSpecification() {
		return array();
	}
}