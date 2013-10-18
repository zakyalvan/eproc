<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Http\Request;
use Application\Form\LoginForm;
use Zend\View\Helper\ViewModel;
use Application\Security\SecurityContext;

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
		
		$this->securityInterceptor()->intercept();
		
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
					$this->redirect()->toRoute('role');
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
		if(!$this->identity()) {
			$this->redirect()->toRoute('login');
		}
		
		$kodeKantor = $this->params()->fromRoute('kantor');
		$kodeRole = $this->params()->fromRoute('role');
		
		if($kodeKantor && $kodeRole) {
			/* @var $securityContext SecurityContext */ 
			$securityContext = $this->getAuthenticationService()->getIdentity();
			
			$validKodeKantor = ($securityContext->getLoggedinUser()->getKantor()->getKode() === $kodeKantor);
			$validKodeRole = false;
			$activeRole = null;
			foreach ($securityContext->getAvailableRoles() as $role) {
				if($role->getKode() === $kodeRole) {
					$validKodeRole = true;
					$activeRole = $role;
				}
			}
			
			if($validKodeKantor && $validKodeRole) {
				$securityContext->setActiveRole($activeRole);
				$this->getAuthenticationService()->getStorage()->write($securityContext);
				$this->redirect()->toRoute('home');
			}
		}
	}
	
	/**
	 * @return AuthenticationService
	 */
	protected function getAuthenticationService() {
		return $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
	}
}