<?php
namespace Contract\Form;

use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;

/**
 * Fieldset untuk header kontrak.
 * Hanya berisi field-field yang diperlukan untuk form kontrak, sebagian attribute diset manual (Bisa jadi dari attribute tender).
 * 
 * @author zakyalvan
 */
class HeaderKontrakFieldset extends Fieldset implements InputFilterProvider {
	public function __construct() {
		parent::__construct('ContractHeader');
		$this->setHydrator(new ClassMethodsHydrator());
		
		$this->add(array(
			'name' => 'nomorKontrak',
			'options' => array(
				'label' => 'Nomor Kontrak'
			),
			'attributes' => array(
				'id' => 'nomorKontrak'
			)
		));
		
		$this->add(array(
			'name' => 'jenisKontrak',
			'options' => array(
				'label' => 'Nomor Kontrak'
			),
			'attributes' => array(
				'id' => 'jenisKontrak'
			)
		));
		
		$this->add(array(
			'name' => 'tanggalMulaiKontrak',
			'options' => array(
				'label' => 'Tanggal Mulai Kontrak'
			),
			'attributes' => array(
				'id' => 'tanggalMulaiKontrak'
			)
		));
		
		$this->add(array(
			'name' => 'tanggalAkhirKontrak',
			'options' => array(
				'label' => 'Tanggal Berakhir Kontrak'
			),
			'attributes' => array(
				'id' => 'nomorKontrak'
			)
		));
		
		$this->add(array(
			'name' => 'judulPekerjaan',
			'options' => array(
				'label' => 'Judul Pekerjaan'
			),
			'attributes' => array(
				'id' => 'judulPekerjaan'
			)
		));
		
		$this->add(array(
			'name' => 'deskripsiPekerjaan',
			'options' => array(
				'label' => 'Dekskripsi Pekerjaan'
			),
			'attributes' => array(
				'id' => 'dekripsiPekerjaan'
			)
		));
	}
	
	/**
	 * Input filter spec untuk fieldset.
	 */
	public function getInputFilterSpecification() {
		return array();
	}
}