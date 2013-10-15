<?php
namespace Contract\Form\Kontrak;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineObjectHydrator;

/**
 * Fieldset untuk milestone kontrak.
 * 
 * @author zakyalvan
 */
class MilestoneFieldset extends Fieldset implements InputFilterProvider {
	CONST DEFAULT_NAME = 'milestone';
	CONST DEFAULT_COLLECTION_NAME = 'listMilestone';
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function __construct(ServiceLocator $serviceLocator, $name = self::DEFAULT_NAME) {
		parent::__construct($name);
		
		$this->serviceLocator = $serviceLocator;
		
		$objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$this->setHydrator(new DoctrineObjectHydrator($objectManager, 'Contract\Entity\Kontrak\Milestone'));
		
		$this->add(array(
			'name' => 'keterangan',
			'type' => 'Zend\Form\Element\Textarea',
			'options' => array(
				'label' => 'Deskripsi'
			),
			'attributes' => array(
				
			)
		));
		
		$this->add(array(
			'name' => 'persentasi',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Bobot'
			),
			'attributes' => array(
				
			)
		));
		
		$this->add(array(
			'name' => 'tanggalTarget',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Tanggal Target'
			),
			'attributes' => array(
				'class' => 'datepicker'
			)
		));
	}
	
	public function getInputFilterSpecification() {
		return array(
			'keterangan' => array(
				'required' => true
			),
			'persentasi' => array(
				'required' => true
			),
			'tanggalTarget' => array(
				'required' => true
			)
		);
	}
}