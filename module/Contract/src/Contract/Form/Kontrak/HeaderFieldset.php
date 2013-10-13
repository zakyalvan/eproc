<?php
namespace Contract\Form\Kontrak;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineObjectHydrator;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

/**
 * Fieldset untuk header kontrak.
 * Hanya berisi field-field yang diperlukan untuk form kontrak, sebagian attribute diset manual (Bisa jadi dari attribute tender).
 * 
 * @author zakyalvan
 */
class HeaderFieldset extends Fieldset implements InputFilterProvider {
	const DEFAULT_NAME = 'headerFieldset';
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function __construct(ServiceLocator $serviceLocator, $name = self::DEFAULT_NAME) {
		parent::__construct($name);
		
		$this->serviceLocator = $serviceLocator;
		
		$objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$this->setHydrator(new DoctrineObjectHydrator($objectManager, 'Contract\Entity\Kontrak\Kontrak'));
		
		$this->add(array(
			'name' => 'nomorKontrak',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Nomor Kontrak'
			),
			'attributes' => array(
				'id' => 'nomorKontrak'
			)
		));
		
		$this->add(array(
			'name' => 'jenisKontrak',
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Jenis Kontrak',
				'empty_option' => '-- Pilih Jenis Kontrak --',
				'value_options' => array(
					'SPK' => 'SPK',
					'PERJANJIAN' => 'PERJANJIAN'
				)
			),
			'attributes' => array(
				'id' => 'jenisKontrak',
				'style' => 'width: 250px;'
			)
		));
		
		$this->add(array(
			'name' => 'tanggalMulaiKontrak',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Tanggal Mulai Kontrak'
			),
			'attributes' => array(
				'id' => 'tanggalMulaiKontrak',
				'style' => 'width: 150px;'
			)
		));
		
		$this->add(array(
			'name' => 'tanggalAkhirKontrak',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Tanggal Berakhir Kontrak'
			),
			'attributes' => array(
				'id' => 'tanggalAkhirKontrak',
				'style' => 'width: 150px;'
			)
		));
		
		$this->add(array(
			'name' => 'judulPekerjaan',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Judul Pekerjaan'
			),
			'attributes' => array(
				'id' => 'judulPekerjaan'
			)
		));
		
		$this->add(array(
			'name' => 'deskripsiPekerjaan',
			'type' => 'Zend\Form\Element\Textarea',
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
		return array(
			'nomorKontrak' => array(
				'required' => true
			),
			'jenisKontrak' => array(
				'required' => true
			),
			'tanggalMulaiKontrak' => array(
				'required' => true
			),
			'tanggalAkhirKontrak' => array(
				'required' => true
			),
			'judulPekerjaan' => array(
				'required' => true
			),
			'deskripsiPekerjaan' => array(
				'required' => false
			)
		);
	}
}