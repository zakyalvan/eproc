<?php
namespace Application\Common;

use Zend\Form\Form;
/**
 * Kontrak untuk searchable object.
 * 
 * @author zakyalvan
 */
interface SearchableInterface {
	/**
	 * Retrieve searchable parameters.
	 * 
	 * @return array
	 */
	public function getSearchableParams();
	
	/**
	 * Retrieve search form.
	 * 
	 * @return Form
	 */
	public function getSearchForm();
}