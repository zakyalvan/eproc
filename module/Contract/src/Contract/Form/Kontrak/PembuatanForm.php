<?php
namespace Contract\Form\Kontrak;

use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineObjectHydarator;
use Contract\Entity\Kontrak\Kontrak;
use Contract\Entity\Kontrak\Komentar;

/**
 * Form untuk pembuatan kontrak.
 * 
 * @author zakyalvan
 */
class PembuatanForm extends Form implements InputFilterProvider {	
	/**
	 * Konstanta array validation group untuk pembuatan kontrak.
	 * 
	 * @var array
	 */
	public static $VALIDATION_DRAFT_KONTRAK = array(
		KontrakFieldset::DEFAULT_NAME => array(
			'jenisKontrak',
			'tanggalMulaiKontrak',
			'tanggalAkhirKontrak',
			'judulPekerjaan',
			'deskripsiPekerjaan'
		),
		JaminanPelaksanaanFieldset::DEFAULT_NAME => array(
			'bankJaminan',
			'nomorJaminan',
			'tanggalMulaiJaminan',
			'tanggalAkhirJaminan',
			'nilaiJaminan'
		),
		KomentarFieldset::DEFAULT_NAME => array(
			'isi'
		)
	);
	
	/**
	 * Konstanta validation group untuk finalisasi kontrak.
	 * 
	 * @var unknown
	 */
	public static $VALIDATION_FINALIZE_KONTRAK = array(
		KontrakFieldset::DEFAULT_NAME => array(
			'nomorKontrak'
		),
		JaminanPelaksanaanFieldset::DEFAULT_NAME => array(
			
		),
		KomentarFieldset::DEFAULT_NAME => array(
			'isi'
		)
	);
	
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * @var Kontrak
	 */
	private $kontrak;
	
	public function __construct(ServiceLocator $serviceLocator) {
		parent::__construct('CreateContract');
	
		$this->serviceLocator = $serviceLocator;
		
		$objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');

		$this->setInputFilter(new InputFilter());
		$this->setAttribute('method', 'post');
		
		$kontrakFieldset = new KontrakFieldset($serviceLocator);
		$kontrakFieldset->setUseAsBaseFieldset(true);
		$this->add($kontrakFieldset);
		
		$this->add(array(
			'name' => 'security',
			'type' => 'Zend\Form\Element\Csrf'
		));
		
		$this->add(array(
			'name' => 'submit',
			'type' => 'Zend\Form\Element\Submit',
			'attributes' => array(
				'value' => 'Simpan',
				'class' => 'uibutton'
			)
		));
		
		$this->add(array(
			'name' => 'submitDraft',
			'type' => 'Zend\Form\Element\Submit',
			'attributes' => array(
				'value' => 'Simpan Draft',
				'class' => 'uibutton'
			)
		));
	}
	
	public function isDraft() {
		
	}
	public function isFinal() {
		
	}
	
	public function getInputFilterSpecification() {
		return array(
			
		);
	}
}