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
		
		$this->add(array(
			'name' => 'kode',
			'options' => array(
			),
			'attributes' => array(
				'id' => 'kode'
			)
		));
		
		$this->add(array(
			'name' => 'tipeKontrak',
			'options' => array(
			
			),
			'attributes' => array(
				'id' => 'tipeKontrak'
			)
		));
	}
	
	public function getInputFilterSpecification() {
		return array(
			'kode' => array(
				'required' => true
			)
		);
	}
}