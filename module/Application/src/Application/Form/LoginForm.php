<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Login form.
 * 
 * @author zakyalvan
 */
class LoginForm extends Form implements InputFilterProviderInterface {
	public function __construct() {
		parent::__construct("login");
		
		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name' => 'username',
			'type' => 'Zend\Form\Element\Text',
			'options' => array(
				'label' => 'Username'
			),
			'attributes' => array(
				
			)
		));
		$this->add(array(
			'name' => 'password',
			'type' => 'Zend\Form\Element\Password',
			'options' => array(
				'label' => 'Password'
			),
			'attributes' => array(

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
				'value' => 'Login'
			)
		));
	}
	
	public function getInputFilterSpecification() {
		return array(
			'username' => array(
				'required' => false
			),
			'password' => array(
				'required' => false
			)
		);
	}
}