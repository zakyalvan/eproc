<?php
namespace Application\Security;

use Zend\EventManager\ListenerAggregateInterface as ListenerAggregate;
use Zend\EventManager\EventManagerInterface as EventManager;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Navigation\Navigation;

/**
 * Intercept setiap request, pastikan resource (controller dan action) yang hendak diakses
 * oleh user memang diizinkan untuk user bersangkutan.
 * 
 * @author zakyalvan
 */
class SecurityInterceptListener implements ListenerAggregate {
	protected $listeners = array();
	
	public function attach(EventManager $events, $priority = 2) {
		$this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), $priority);
	}
	
	public function detach(EventManager $events) {
		foreach ($this->listeners as $index => $listener) {
			if ($events->detach($listener)) {
				unset($this->listeners[$index]);
			}
		}
	}
	
	/**
	 * Event listener ini, selain menggunakan auth service, juga menggunakan komponen navigation.
	 * 
	 * @param MvcEvent $event
	 */
	public function onDispatch(MvcEvent $event) {
		/* @var $serviceLocator ServiceLocatorInterface */
		$serviceLocator = $event->getApplication()->getServiceManager();
		/* @var $authService AuthenticationService */
		$authService = $serviceLocator->get('Zend\Authentication\AuthenticationService');
		
		/* @var $pageContainer Navigation */
		$pageContainer = $serviceLocator->get('Zend\Navigation\Navigation');
		
		$routeMatch = $event->getRouteMatch();
		
		
		if($authService->hasIdentity()) {
			
		}
	}
}