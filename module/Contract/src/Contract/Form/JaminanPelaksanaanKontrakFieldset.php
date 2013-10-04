<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

/**
 * Fieldset jaminan pelaksanaan kontrak.
 * 
 * @author zakyalvan
 */
class JaminanPelaksanaanKontrakFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('JaminanPelaksanaanKontrak');
		$this->setHydrator(new ClassMethodsHydrator());
	}
	
	public function getInputFilterSpecification() {
		return array();
	}
}