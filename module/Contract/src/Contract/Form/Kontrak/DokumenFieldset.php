<?php
namespace Contract\Form\Kontrak;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface as InputFilterProvider;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineObjectHydrator;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Contract\Entity\Kontrak\Dokumen;

/**
 * Fieldset dokumen kontrak.
 * 
 * @author zakyalvan
 */
class DokumenFieldset extends Fieldset implements InputFilterProvider {
	const DEFAULT_NAME = 'dokumen';
	const DEFAULT_COLLECTION_NAME = 'listDokumen';
	
	private $serviceLocator;
	
	public function __construct(ServiceLocator $serviceLocator, $name = self::DEFAULT_NAME) {
		parent::__construct($name);
		
		$this->serviceLocator = $serviceLocator;

		$objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
		
		$this->setHydrator(new DoctrineObjectHydrator($objectManager, 'Contract\Entity\Kontrak\Dokumen'));
		$this->setObject(new Dokumen());
		
		$this->add(array(
			'name' => 'kodeKategori',
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Kategori',
				'empty_option' => '-- Pilih Kategori Dokumen --',
				'value_options' => array(
					Dokumen::DOKUMEN_KONTRAK_UTAMA => 'Kontrak Utama',
					Dokumen::DOKUMEN_LAMPIRAN_A_PERSYARATAN_KHUSUS => 'Lampiran A - Persyaratan Khusus',
					Dokumen::DOKUMEN_LAMPIRAN_B_LINGKUP_PEKERJAAN => 'Lampiran B - Lingkup Pekerjaan',
					Dokumen::DOKUMEN_LAMPIRAN_C_HARGA_PEMBAYARAN => 'Lampiran C - Harga dan Pembayaran',
					Dokumen::DOKUMEN_LAMPIRAN_C_PERSYARATAN_UMUM => 'Lampiran D - Persyaratan Umum',
				)
			),
			'attributes' => array(
				'style' => 'width: 100%;'
			)
		));
		
		$this->add(array(
			'name' => 'namaFile',
			'type' => 'Zend\Form\Element\File',
			'options' => array(
				'label' => 'File'
			),
			'attributes' => array(
				
			)
		));
		
		$this->add(array(
			'name' => 'keterangan',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Keterangan'
			),
			'attributes' => array(
				'style' => 'width: 300px;'
			)
		));
		
		$this->add(array(
			'name' => 'statusPublish',
			'type' => 'Zend\Form\Element\Checkbox',
			'options' => array(
				'label' => 'Kirim ke Vendor'
			),
			'attributes' => array(
				
			)
		));
	}
	
	public function getInputFilterSpecification() {
		return array(
			'kodeKategori' => array(
				'required' => false
			),
			'namaFile' => array(
				'required' => false
			),
			'keterangan' => array(
				'required' => false
			),
			'statusPublish' => array(
				'required' => false
			)
		);
	}
}