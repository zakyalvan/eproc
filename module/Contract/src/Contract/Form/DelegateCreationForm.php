<?php
namespace Contract\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

/**
 * Form untuk aktifitas pertama dalam inisiasi kontrak (Penunjukan penata pelaksanaan no lelang).
 * 
 * @author zakyalvan
 */
class DelegateCreationForm extends Form implements ServiceLocatorAwareInterface {
	private $serviceLocator;
	
	public function __construct() {
		parent::__construct("DelegateCreation");
		
		
	}
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}