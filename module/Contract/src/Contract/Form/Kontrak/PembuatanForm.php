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
use Contract\Form\Kontrak\DokumenFieldset;
use Zend\Form\Element\Collection as FormElementCollection;

/**
 * Form untuk pembuatan kontrak.
 * 
 * @author zakyalvan
 */
class PembuatanForm extends Form implements InputFilterProvider {
	const DOKUMEN_FIELDSET_COLLECTION_NAME = 'dokumenFiledsetCollection';
	
	/**
	 * Konstanta array validation group untuk pembuatan kontrak.
	 * 
	 * @var array
	 */
	public static $VALIDATION_DRAFT_KONTRAK = array(
		HeaderFieldset::DEFAULT_NAME => array(
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
		HeaderFieldset::DEFAULT_NAME => array(
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
		
		$headerFieldset = new HeaderFieldset($serviceLocator);
		$this->add($headerFieldset);
		
		$jaminanPelaksanaanFieldset = new JaminanPelaksanaanFieldset($serviceLocator);
		$this->add($jaminanPelaksanaanFieldset);
		
		$dokumenFieldsetCollection = new FormElementCollection(self::DOKUMEN_FIELDSET_COLLECTION_NAME);
		$dokumenFieldsetCollection->setCount(5);
		$dokumenFieldsetCollection->setShouldCreateTemplate(false);
		$dokumenFieldset = new DokumenFieldset($serviceLocator);
		$dokumenFieldsetCollection->setTargetElement($dokumenFieldset);
		$this->add($dokumenFieldsetCollection);
		
		$komentarFieldset = new KomentarFieldset($serviceLocator);
		$this->add($komentarFieldset);
		
		
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
	
	/**
	 * Set object kontrak.
	 * 
	 * @param Kontrak $kontrak
	 */
	public function setKontrakObject(Kontrak $kontrak) {
		$this->kontrak = $kontrak;
		
		$this->get(HeaderFieldset::DEFAULT_NAME)->setObject($kontrak);
		$this->get(JaminanPelaksanaanFieldset::DEFAULT_NAME)->setObject($kontrak);
	}
	
	public function setKomentarObject(Komentar $komentar) {
		$this->get(KomentarFieldset::DEFAULT_NAME)->setObject($komentar);
	}
	
	public function setKontrakItemObjects($items) {
		
	}
	
	public function getInputFilterSpecification() {
		return array(
			
		);
	}
}