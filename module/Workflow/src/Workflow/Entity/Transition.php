<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_WF_TRANSITION")
 * 
 * @author zakyalvan
 */
class Transition {
	const TRIGGER_BY_USER = "USER";
	const TRIGGER_BY_MESSAGE = "MESG";
	const TRIGGER_BY_AUTO = "AUTO";
	const TRIGGER_BY_TIME = "TIME";
	
	/**
	 * @Orm\Id
	 * @Orm\GeneratedValue(strategy="AUTO")
	 * @Orm\Column(name="TRANSITION_ID", type="integer")
	 */
	protected $id;
	
	/**
	 * Ini jenis trigger dari transition ini.
	 * USER jika transisi ini harus ditrigger uleh user.
	 * AUTO jika transisi ini ditrigger secara automatis.
	 * MESG jika transisi ini ditrigger setelah diterimanya message.
	 * TIME jika transisi ini ditrigger oleh waktu (contoh dalam percabangan implisit join).
	 * Perlu dicatat, untuk setiap transisi yang harus ditrigger oleh user maka sebelum
	 * 
	 * @Orm\Column(name="TRANSITION_TRIGGER", type="string")
	 */
	protected $triggerType;
	
	/**
	 * @Orm\ManyToOne(targetEntity="\Workflow\Entity\Workflow")
	 * @Orm\JoinColumn(name="WORKFLOW_ID", type="string")
	 */
	protected $workflow;
	
	/**
	 * @Orm\Column(name="TRANSITION_NAME", type="string")
	 */
	protected $name;
	
	/**
	 * @Orm\Column(name="TRANSITION_DESC", type="string")
	 */
	protected $description;
	
	/**
	 * @Orm\Column(name="TGL_REKAM")
	 */
	protected $createdDate;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_REKAM", referencedColumnName="KODE_USER")
	 */
	protected $createdBy;
	
	/**
	 * @Orm\Column(name="TGL_UBAH")
	 */
	protected $updatedDate;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="lazy")
	 * @Orm\JoinColumn(name="PETUGAS_UBAH", referencedColumnName="KODE_USER")
	 */
	protected $updatedBy;
	
	public function getId() {
		return $id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getWorkflow() {
		return $this->workflow;
	}
	public function setWorkflow($workflow) {
		$this->workflow = $workflow;
	}
	
	public function getName() {
		return $name;
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
	
	public function getCreatedDate() {
		return $this->createdDate;
	}
	public function getCreatedBy() {
		return $this->createdBy;
	}
	
	public function getUpdatedDate() {
		return $this->updatedDate;
	}
	public function getUpdatedBy() {
		return $this->updatedBy;
	}
}