<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Contract\Entity\Kontrak\Kontrak;

/**
 * Fieldset jaminan pelaksanaan kontrak.
 * 
 * @author zakyalvan
 */
class JaminanPelaksanaanKontrakFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('JaminanPelaksanaanKontrak');
		$this->setHydrator(new ClassMethodsHydrator());
		
		$this->add(array(
			'name' => 'bankJaminan',
			'options' => array(
				'label' => 'Nama Bank'
			),
			'attributes' => array(
				'id' => 'bankJaminan',
				'required' => 'required'
			)
		));
		
		$this->add(array(
			'name' => 'nomorJaminan',
			'options' => array(
				'label' => 'Nomor Jaminan'
			),
			'attributes' => array(
				'id' => 'nomorJaminan',
				'required' => 'required'
			)
		));
		
		$this->add(array(
			'name' => 'tanggalMulaiJaminan'
		));
		
		$this->add(array(
			'name' => 'tanggalAkhirJaminan'
		));
		
		$this->add(array(
			'name' => 'nilaiJaminan',
			'options' => array(
				'label' => 'Nilai Jaminan'
			),
			'attributes' => array(
				'id' => 'nilaiJaminan'
			)	 
		));
		
		$this->add(array(
			'name' => 'lampiranJaminan'
		));
	}
	
	public function getInputFilterSpecification() {
		return array(
			'bankJaminan' => array(
				'required' => true
			),
			'nomorJaminan' => array(
				'required' => true
			),
			'tanggalMulaiJaminan' => array(
				'required' => true
			),
			'tanggalAkhirJaminan' => array(
				'required' => true
			),
			'nilaiJaminan' => array(
				'required' => true
			),
			'lampiranJaminan' => array(
				
			)
		);
	}
}