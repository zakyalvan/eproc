<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_TASK")
 * 
 * @author zakyalvan
 */
class Task {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="TASK_ID", type="integer")
	 */
	private $id;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @Orm\Column(name="TASK_CONTEXT", type="string", nullable=false)
	 */
	private $context;
	public function getContext() {
		return $this->context;
	}
	public function setContext($context) {
		$this->context = $context;
	}
	
	/**
	 * @Orm\Column(name="TASK_NAME", type="string", nullable=false)
	 */
	private $name;
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @Orm\Column(name="TASK_DESC", type="string", nullable=true)
	 */
	private $description;
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * @Orm\Column(name="TASK_URL", type="string", nullable=false)
	 */
	private $url;
	public function getUrl() {
		return $this->url;
	}
	public function setUrl($url) {
		$this->url = $url;
	}
}