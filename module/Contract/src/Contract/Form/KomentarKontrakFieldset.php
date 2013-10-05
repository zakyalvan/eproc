<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Fieldset komentar kontrak.
 * 
 * @author zakyalvan
 */
class KomentarKontrakFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('KomentarKontrak');
		$this->setHydrator(new ClassMethodsHydrator());
	}
	public function getInputFilterSpecification() {
		return array();
	}
}