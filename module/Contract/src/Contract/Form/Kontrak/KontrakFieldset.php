<?php
namespace Contract\Form\Kontrak;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Form\Element\Collection as FormElementCollection;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineObjectHydrator;
use Contract\Entity\Kontrak\Kontrak;

/**
 * Fieldset untuk header kontrak.
 * Hanya berisi field-field yang diperlukan untuk form kontrak, sebagian attribute diset manual (Bisa jadi dari attribute tender).
 * 
 * @author zakyalvan
 */
class KontrakFieldset extends Fieldset implements InputFilterProvider {
	const DEFAULT_NAME = 'kontrak';
	
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
					Kontrak::JENIS_SPK => 'SPK',
					Kontrak::JENIS_PERJANJIAN => 'PERJANJIAN'
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
				'style' => 'width: 150px;',
				'class' => 'datepicker'
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
				'style' => 'width: 150px;',
				'class' => 'datepicker'
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
			'name' => 'lingkupPekerjaan',
			'type' => 'Zend\Form\Element\Textarea',
			'options' => array(
				'label' => 'Dekskripsi Pekerjaan'
			),
			'attributes' => array(
				'class' => 'grow'
			)
		));
		
		// Tambahain semua fieldset.
		$jaminanPelaksanaanFieldset = new JaminanPelaksanaanFieldset($serviceLocator);
		$this->add($jaminanPelaksanaanFieldset);
		
		$dokumenFieldsetCollection = new FormElementCollection(DokumenFieldset::DEFAULT_COLLECTION_NAME);
		$dokumenFieldsetCollection->setCount(5);
		$dokumenFieldsetCollection->setAllowAdd(false);
		$dokumenFieldsetCollection->setAllowRemove(false);
		$dokumenFieldsetCollection->setShouldCreateTemplate(true);
		$dokumenFieldset = new DokumenFieldset($serviceLocator);
		$dokumenFieldsetCollection->setTargetElement($dokumenFieldset);
		$this->add($dokumenFieldsetCollection);
		
// 		$milestoneFieldsetCollection = new FormElementCollection(MilestoneFieldset::DEFAULT_COLLECTION_NAME);
// 		$milestoneFieldsetCollection->setAllowAdd(true);
// 		$milestoneFieldsetCollection->setAllowRemove(true);
// 		$milestoneFieldsetCollection->setShouldCreateTemplate(true);
// 		$milestoneFieldset = new MilestoneFieldset($serviceLocator);
// 		$milestoneFieldsetCollection->setTargetElement($milestoneFieldset);
// 		$this->add($milestoneFieldsetCollection);
		
		$komentarFieldsetCollection = new FormElementCollection(KomentarFieldset::DEFAULT_COLLECTION_NAME);
		$komentarFieldsetCollection->setAllowAdd(true);
		$komentarFieldsetCollection->setAllowRemove(true);
		$komentarFieldsetCollection->setShouldCreateTemplate(true);
		$komentarFieldset = new KomentarFieldset($serviceLocator);
		$komentarFieldsetCollection->setTargetElement($komentarFieldset);
		$this->add($komentarFieldsetCollection);
	}
	
	/**
	 * Input filter spec untuk fieldset.
	 */
	public function getInputFilterSpecification() {
		return array(
			'nomorKontrak' => array(
				'required' => false
			),
			'jenisKontrak' => array(
				'required' => false
			),
			'tanggalMulaiKontrak' => array(
				'required' => false,
				'filters' => array(
// 					array(
// 						'name' => 'DateTimeFormatter',
// 						'options' => array(
// 							'format' => 'd/m/Y'
// 						)
// 					)
				)
			),
			'tanggalAkhirKontrak' => array(
				'required' => false,
				'filters' => array(
// 					array(
// 						'name' => 'DateTimeFormatter',
// 						'options' => array(
// 							'format' => 'd/m/Y'
// 						)
// 					)
				)
			),
			'judulPekerjaan' => array(
				'required' => false
			),
			'lingkupPekerjaan' => array(
				'required' => false
			)
		);
	}
}