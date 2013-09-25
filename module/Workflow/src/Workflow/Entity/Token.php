<?php
namespace Workflow\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Data sebuah token dari instance workflow tertentu.
 * 
 * @Orm\Entity(repositoryClass="Workflow\Entity\Repository\TokenRepository")
 * @Orm\Table(name="EP_WF_TOKEN")
 * 
 * @author zakyalvan
 */
class Token {
	const STATUS_FREE = 'FREE';
	const STATUS_CONSUMED = 'CONS';
	const STATUS_CANCELED = 'CANC';
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="TOKEN_ID", type="integer")
	 */
	protected $id;
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Workflow", fetch="LAZY")
	 * @Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID")
	 *
	 * @var Workflow
	 */
	protected $workflow;
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Instance", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="INSTANCE_ID", referencedColumnName="INSTANCE_ID")})
	 * 
	 * @var Instance
	 */
	protected $instance;
	
	/**
	 * Di mana token ini berada.
	 * 
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Place", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="PLACE_ID", referencedColumnName="PLACE_ID")})
	 * 
	 * @var Place
	 */
	protected $place;
	
	/**
	 * @Orm\Column(name="TOKEN_CONTEXT", type="string")
	 */
	protected $context;
	
	/**
	 * Status dari token ini, menentukan apakah transition setelah place (di mana token ini berada 
	 * bisa difire atau tidak). Default value FREE.
	 * 
	 * @Orm\Column(name="TOKEN_STATUS", type="string")
	 */
	protected $status = self::STATUS_FREE;
	
	/**
	 * Kapan token ini dibuat.
	 * 
	 * @Orm\Column(name="ENABLED_DATE", type="datetime")
	 */
	protected $enabledDate;
	
	/**
	 * @Orm\Column(name="CANCELED_DATE", type="datetime")
	 */
	protected $canceledDate;
	
	/**
	 * @Orm\Column(name="CONSUMED_DATE", type="datetime")
	 */
	protected $consumedDate;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getInstance() {
		return $this->instance;
	}
	public function setInstance(Instance $instance) {
		$this->instance = $instance;
	}
	
	public function getWorkflow() {
		return $this->workflow;
	}
	public function setWorkflow(Workflow $workflow) {
		$this->workflow = $workflow;
	}
	
	public function getPlace() {
		return $this->place;
	}
	public function setPlace(Place $place) {
		$this->place = $place;
	}
	
	public function getContext() {
		return $this->context;
	}
	public function setContext($context) {
		$this->context = $context;
	}
	
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	public function getEnabledDate() {
		return $this->enabledDate;
	}
	public function setEnabledDate($enabledDate) {
		$this->enabledDate = $enabledDate;
	}
	
	public function getCanceledDate() {
		return $this->canceledDate;
	}
	public function setCanceledDate($canceledDate) {
		$this->canceledDate = $canceledDate;
	}
	
	public function getConsumedDate() {
		return $this->consumedDate;
	}
	public function setConsumedDate($consumedDate) {
		$this->consumedDate = $consumedDate;
	}
}