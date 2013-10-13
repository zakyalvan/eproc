<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

/**
 * Fieldset contract item.
 * 
 * @author zakyalvan
 */
class ItemFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('ItemKontrak');
		$this->setHydrator(new ClassMethodsHydrator());
		
	}
	
	public function getInputFilterSpecification() {
		return array();
	}
}
