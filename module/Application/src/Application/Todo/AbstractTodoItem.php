<?php
namespace Application\Todo;

/**
 * Kontrak untuk todo item.
 * 
 * @author zakyalvan
 */
abstract class AbstractTodoItem {
	/**
	 * Context dari todo item.
	 * 
	 * @var string
	 */
	protected $context;
	
	/**
	 * Data untuk todo item
	 * 
	 * @var array
	 */
	protected $datas = array();
	
	/**
	 * Url untuk mengeksekusi todo item.
	 * 
	 * @var string
	 */
	protected $actionUrl;
	
	/**
	 * Kapan todo item ini dibuat/mulai aktif.
	 * 
	 * @var unknown
	 */
	protected $createdDate;
	
	public function __construct($context, $actionUrl, $createdDate) {
		$this->context = $context;
		$this->actionUrl = $actionUrl;
		$this->createdDate = $createdDate;
	}
	
	public function getContext() {
		return $this->context;
	}
	public function setContext($context) {
		$this->context = $context;
	}
	
	public function getActionUrl() {
		return $this->actionUrl;
	}
	public function setActionUrl($actionUrl) {
		$this->actionUrl = $actionUrl;
	}
	
	public function getCreatedDate() {
		return $this->createdDate;
	}
	public function setCreatedDate($createdDate) {
		$this->createdDate = $createdDate;
	}
	
	public function getData($name) {
		if(isset($this->datas[$name])) {
			return $this->datas[$name];
		}
		return null;
	}
	public function hasData($name) {
		return isset($this->datas[$name]);
	}
	public function setData($name, $value) {
		$this->datas[$name] = $value;
	}
	
	public function __get($name) {
		return $this->getData($name);
	}
	public function __set($name, $value) {
		$this->setData($name, $value);
	}
	public function __isset($name) {
		return $this->hasData($name);
	}
}