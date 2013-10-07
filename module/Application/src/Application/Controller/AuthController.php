<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Http\Request;
use Application\Form\LoginForm;
use Zend\View\Helper\ViewModel;

/**
 * Kelas kontroller yang handle urusan login dari serta logout dari user.
 * Untuk kepentingan autentikasi ini, sepesifik menggunakan kelas autentikasi 
 * yang disediakan oleh doctrine module.
 * 
 * @author zakyalvan
 * @see https://github.com/doctrine/DoctrineModule/blob/master/docs/authentication.md
 */
class AuthController extends AbstractActionController {
	/**
	 * Handle login request.
	 * 
	 * @return multitype:\Application\Form\LoginForm
	 */
	public function loginAction() {
		$authService = $this->getAuthenticationService();
		
		// Jika sebelumnya udah login, redirect ke home.
		if($authService->hasIdentity()) {
			$this->redirect()->toRoute("home");
		}
		
		$loginForm = new LoginForm();
		
		// Jika request method adalah post.
		if($this->getRequest()->isPost()) {
			$loginForm->setData($this->getRequest()->getPost());
			
			// Jika form yang disubmit valid.
			if($loginForm->isValid()) {
				$username = $this->getRequest()->getPost('username');
				$password = $this->getRequest()->getPost('password');
				
				$authService->getAdapter()->setIdentityValue($username);
				$authService->getAdapter()->setCredentialValue($password);
				
				$result = $authService->authenticate();
				if($result->isValid()) {
					// Berhasil, redirect ke home.
					$this->redirect()->toRoute('home');
				}
				else {
					// Tampilin error di sini.
				}
			}
			// Jika form yang disubmit tidak valid.
			else {
				
			}
		}
		
		return array(
			'loginForm' => $loginForm
		);
	}
	
	/**
	 * Handle logout request.
	 */
	public function logoutAction() {
		if($this->getAuthenticationService()->hasIdentity()) {
			$this->getAuthenticationService()->clearIdentity();
		}
		$this->redirect()->toRoute("login");
	}
	
	/**
	 * Handle pemilihan role user.
	 */
	public function roleAction() {
		
	}
	
	/**
	 * @return AuthenticationService
	 */
	protected function getAuthenticationService() {
		return $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
	}
}