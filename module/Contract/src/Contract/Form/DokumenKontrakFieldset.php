<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

/**
 * Fieldset dokumen kontrak.
 * 
 * @author zakyalvan
 */
class DokumenKontrakFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('DokumenKontrak');
		$this->setHydrator(new ClassMethodsHydrator());
	}
	
	public function getInputFilterSpecification() {
		return array();
	}
}