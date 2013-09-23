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
	 * @Orm\Column(name="TASK_ID", type="string")
	 */
	private $id;
	
	/**
	 * @Orm\Column(name="TASK_NAME", type="string")
	 */
	private $name;
	
	/**
	 * @Orm\Column(name="TASK_DESC", type="string")
	 */
	private $description;
	
	/**
	 * @Orm\Column(name="TASK_URL", type="string")
	 */
	private $url;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function getUrl() {
		return $this->url;
	}
	public function setUrl($url) {
		$this->url = $url;
	}
}