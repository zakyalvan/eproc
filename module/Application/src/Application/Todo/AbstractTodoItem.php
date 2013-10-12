<?php
namespace Application\Todo;

/**
 * Kontrak untuk todo item.
 * 
 * @author zakyalvan
 */
abstract class AbstractTodoItem extends \ArrayObject {
	/**
	 * Context dari todo item.
	 * 
	 * @var string
	 */
	protected $context;
	
	/**
	 * Nama route ke action untuk mengeksekusi todo item.
	 * Properti ini spesifik ke zend-framework 2 (mvc-router).
	 * 
	 * @var string
	 */
	protected $actionRoute;
	
	/**
	 * Parameter untuk route ke action untuk mengeksekusi todo item.
	 * Properti ini spesifik ke zend-framework 2 (mvc-router).
	 * 
	 * @var array
	 */
	protected $actionRouteParams = array();
	
	/**
	 * Url untuk mengeksekusi todo item.
	 * 
	 * @var string
	 */
	protected $actionUrl;
	
	/**
	 * Apakah menggunakan action-route atau plain action-url.
	 * 
	 * @var boolean
	 */
	protected $useActionRoute = true;
	
	/**
	 * Kapan todo item ini dibuat/mulai aktif.
	 * 
	 * @var \DateTime
	 */
	protected $createdDate;
	
	public function __construct($context, $actionRoute, $actionRouteParams, $actionUrl, $createdDate) {
		parent::__construct(array());
		
		$this->setContext($context);
		$this->setActionRoute($actionRoute);
		$this->setActionRouteParams($actionRouteParams);
		$this->setActionUrl($actionUrl);
		$this->setCreatedDate($createdDate);
	}
	
	public function getContext() {
		return $this->context;
	}
	protected function setContext($context) {
		$this->context = $context;
	}
	
	public function getActionRoute() {
		return $this->actionRoute;
	}
	protected function setActionRoute($actionRoute) {
		$this->actionRoute = $actionRoute;
	}
	
	public function getActionRouteParams() {
		return $this->actionRouteParams;
	}
	protected function setActionRouteParams($actionRouteParams) {
		$this->actionRouteParams = $actionRouteParams;
	}
	
	public function getActionUrl() {
		return $this->formatActionUrl();
	}
	protected function setActionUrl($actionUrl) {
		$this->actionUrl = $actionUrl;
	}
	
	public function isUseActionRoute() {
		return $this->useActionRoute;
	}
	protected function setUseActionRoute($useActionRoute) {
		$this->useActionRoute = $useActionRoute;
	}
	
	public function getCreatedDate() {
		return $this->createdDate;
	}
	protected function setCreatedDate($createdDate) {
		$this->createdDate = $createdDate;
	}
}