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
	 * Untuk penggunaan zf2 mvc, address ini adalah nama route ke halaman dimana task harus dieksekusi.
	 * 
	 * @Orm\Column(name="TASK_ADDRESS", type="string", nullable=false)
	 */
	private $address;
	public function getAddress() {
		return $this->address;
	}
	public function setUrl($address) {
		$this->address = $address;
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	protected $createdDate;
	public function getCreatedDate() {
		return $this->createdDate;
	}
	public function setCreatedDate(\DateTime $createdDate) {
		$this->createdDate = $createdDate;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_REKAM", type="string", nullable=true)
	 *
	 * @var string
	 */
	protected $createdBy;
	public function getCreatedBy() {
		return $this->createdBy;
	}
	public function setCreatedBy($createdBy) {
		$this->createdBy = $createdBy;
	}
	
	/**
	 * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	protected $updatedDate;
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	public function setUpdatedDate(\DateTime $updateDate) {
		$this->updatedDate = $updateDate;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_UBAH", type="string", nullable=true)
	 *
	 * @var string
	 */
	protected $updatedBy;
	public function getUpdatedBy() {
		return $this->updatedBy;
	}
	public function setUpdatedBy($updatedBy) {
		$this->updatedBy = $updatedBy;
	}
}