<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

/**
 * Fieldset untuk milestone kontrak.
 * 
 * @author zakyalvan
 */
class MilestoneKontrakFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('MilestoneKontrak');
		$this->setHydrator(new ClassMethodsHydrator());
		
		
	}
	
	public function getInputFilterSpecification() {
		return array();
	}
}