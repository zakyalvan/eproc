<?php
namespace Contract\Form\Kontrak;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Contract\Entity\Kontrak\Kontrak;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

/**
 * Fieldset jaminan pelaksanaan kontrak.
 * 
 * @author zakyalvan
 */
class JaminanPelaksanaanFieldset extends Fieldset implements InputFilterProvider {
	const DEFAULT_NAME = 'listJaminanPelaksanaan';
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function __construct(ServiceLocator $serviceLocator, $name = self::DEFAULT_NAME) {
		parent::__construct($name);
		
		$this->serviceLocator = $serviceLocator;
		$objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$this->setHydrator(new DoctrineObject($objectManager, 'Contract\Entity\Kontrak\Kontrak'));
		
		$this->add(array(
			'name' => 'bankJaminan',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Nama Bank'
			),
			'attributes' => array(
				'required' => 'required',
				'style' => 'width: 250px;'
			)
		));
		
		$this->add(array(
			'name' => 'nomorJaminan',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Nomor Jaminan'
			),
			'attributes' => array(
				'required' => 'required',
				'style' => 'width: 250px;'
			)
		));
		
		$this->add(array(
			'name' => 'tanggalMulaiJaminan',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Tanggal Mulai'
			),
			'attributes' => array(
				'required' => 'required',
				'style' => 'width: 150px;'
			)
		));
		
		$this->add(array(
			'name' => 'tanggalAkhirJaminan',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Tanggal Berakhir'
			),
			'attributes' => array(
				'required' => 'required',
				'style' => 'width: 150px;'
			)
		));
		
		$this->add(array(
			'name' => 'nilaiJaminan',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Nilai Jaminan'
			),
			'attributes' => array(
				'required' => 'required',
				'style' => 'width: 250px;'
			)
		));
		
		$this->add(array(
			'name' => 'lampiranJaminan',
			'type' => 'Zend\Form\Element\File',
			'options' => array(
				'label' => 'Lampiran Jaminan'
			),
			'attributes' => array(
				
			)
		));
	}
	
	public function getInputFilterSpecification() {
		return array(
			'bankJaminan' => array(
				'required' => false
			),
			'nomorJaminan' => array(
				'required' => false
			),
			'tanggalMulaiJaminan' => array(
				'required' => false
			),
			'tanggalAkhirJaminan' => array(
				'required' => false
			),
			'nilaiJaminan' => array(
				'required' => false
			),
			'lampiranJaminan' => array(
				'required' => false
			)
		);
	}
}