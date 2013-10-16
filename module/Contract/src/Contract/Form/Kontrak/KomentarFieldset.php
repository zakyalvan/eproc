<?php
namespace Contract\Form\Kontrak;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineObjectHydrator;
use Contract\Entity\Kontrak\Komentar;

/**
 * Fieldset komentar kontrak.
 * 
 * @author zakyalvan
 */
class KomentarFieldset extends Fieldset implements InputFilterProvider {
	const DEFAULT_NAME = 'komentar';
	const DEFAULT_COLLECTION_NAME = 'listKomentar';
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function __construct(ServiceLocator $serviceLocator, $name = self::DEFAULT_NAME) {
		parent::__construct($name);
		
		$this->serviceLocator = $serviceLocator;
		
		$objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$this->setHydrator(new DoctrineObjectHydrator($objectManager, 'Contract\Entity\Kontrak\Komentar'));
		$this->setObject(new Komentar());
		
		$this->add(array(
			'name' => 'isi',
			'type' => 'Zend\Form\Element\Textarea',
			'options' => array(
				'label' => 'Komentar Anda'
			),
			'attributes' => array(
				'class' => 'grow'
			)
		));
	}
	public function getInputFilterSpecification() {
		return array(
			'isi' => array(
				'required' => true
			)
		);
	}
}