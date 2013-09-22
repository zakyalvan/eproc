<?php
namespace Application\Form;

use Zend\Form\Form;

/**
 * Login form.
 * 
 * @author zakyalvan
 */
class LoginForm extends Form {
	public function __construct() {
		parent::__construct("login");
		
		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name' => 'username',
			'attributes' => array(
				'type' => 'text'
			)
		));
		$this->add(array(
			'name' => 'password',
			'attributes' => array(
				'type' => 'password'
			)
		));
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Login'
			)
		));
	}
}