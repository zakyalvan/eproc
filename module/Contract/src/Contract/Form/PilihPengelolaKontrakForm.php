<?php
namespace Contract\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

/**
 * Form untuk aktifitas pertama dalam inisiasi kontrak (Penunjukan penata pelaksanaan no lelang).
 * 
 * @author zakyalvan
 */
class PilihPengelolaKontrakForm extends Form {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	public function __construct(ServiceLocator $serviceLocator) {
		parent::__construct("DelegateCreation");
		if($serviceLocator == null) {
			throw new \InvalidArgumentException('Parameter service-locator harus diberikan', 100, null);
		}
	}
}