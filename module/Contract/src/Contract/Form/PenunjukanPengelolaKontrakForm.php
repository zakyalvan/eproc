<?php
namespace Contract\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Application\Entity\User;
use Zend\Form\Element\Select;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineObjectHydrator;

/**
 * Form untuk aktifitas pertama dalam inisiasi kontrak (Penunjukan penata pelaksanaan no lelang).
 * 
 * @author zakyalvan
 */
class PenunjukanPengelolaKontrakForm extends Form implements InputFilterProvider {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function __construct(ServiceLocator $serviceLocator) {
		parent::__construct('AssignPengelola');
		
		$this->serviceLocator = $serviceLocator;
		
		$objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$this->setAttribute('method', 'post');
		$this->setHydrator(new DoctrineObjectHydrator($objectManager, 'Contract\Entity\PenunjukanPengelola'));
		$this->setInputFilter(new InputFilter());
		
		$this->add(array(
			'name' => 'userPengelola',
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Pengelola Kontrak',
				'empty_option' => '-- Pilih User --' 
			),
			'attributes' => array(
				'style' => 'width: 250px;'
			)
		));
		
		$this->add(array(
			'name' => 'komentar',
			'type' => 'Zend\Form\Element\Textarea',
			'options' => array(
				'label' => 'Komentar'
			),
			'attributes' => array(
				'class' => 'grow'
			)
		));
		
		$this->add(array(
			'name' => 'security',
			'type' => 'Zend\Form\Element\Csrf'
		));
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'Zend\Form\Element\Submit',
			'attributes' => array(
				'value' => 'Simpan Penunjukan',
				'class' => 'uibutton'
			)
		));
	}
	
	public function setListPengelolaKontrak($listPengelolaKontrak) {
		$arrayPengelolaKontrak = array();
		foreach ($listPengelolaKontrak as $kode => $pengelolaKontrak) {
			if($pengelolaKontrak instanceof User) {
				$arrayPengelolaKontrak[$pengelolaKontrak->getKode()] = $pengelolaKontrak->getNama();
			}
			else {
				$arrayPengelolaKontrak[$kode] = $pengelolaKontrak;
			}
		}
		
		/* @var $selectUserPengelola Select */
		$selectUserPengelola = $this->get('userPengelola');
		$selectUserPengelola->setValueOptions($arrayPengelolaKontrak);
	}
	
	public function getInputFilterSpecification() {
		return array(
			'userPengelola' => array(
				'required' => true
			),
			'komentar' => array(
				'required' => false
			)
		);
	}
}