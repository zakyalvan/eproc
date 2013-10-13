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
	 * @Orm\Column(name="WORKFLOW_ID", type="string")
	 * 
	 * @var string
	 */
	private $workflowId;
	
	/**
	 * @Orm\Column(name="INSTANCE_ID", type="integer")
	 * 
	 * @var integer
	 */
	private $instanceId;
	
	/**
	 * @Orm\Column(name="PLACE_ID", type="integer")
	 * 
	 * @var integer
	 */
	private $placeId;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="TOKEN_ID", type="integer")
	 */
	protected $id;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Instance", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="INSTANCE_ID", referencedColumnName="INSTANCE_ID")})
	 * 
	 * @var Instance
	 */
	protected $instance;
	public function getInstance() {
		return $this->instance;
	}
	public function setInstance(Instance $instance) {
		$this->instance = $instance;
	}
	
	/**
	 * Di mana token ini berada.
	 * 
	 * @Orm\ManyToOne(targetEntity="Workflow\Entity\Place", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="WORKFLOW_ID", type="string", length="5", referencedColumnName="WORKFLOW_ID"), @Orm\JoinColumn(name="PLACE_ID", type="integer", referencedColumnName="PLACE_ID")})
	 * 
	 * @var Place
	 */
	protected $place;
	public function getPlace() {
		return $this->place;
	}
	public function setPlace(Place $place) {
		$this->place = $place;
	}
	
	/**
	 * @Orm\Column(name="TOKEN_CONTEXT", type="string", nullable=true)
	 */
	protected $context;
	public function getContext() {
		return $this->context;
	}
	public function setContext($context) {
		$this->context = $context;
	}
	
	/**
	 * Status dari token ini, menentukan apakah transition setelah place (di mana token ini berada 
	 * bisa difire atau tidak). Default value FREE.
	 * 
	 * @Orm\Column(name="TOKEN_STATUS", type="string", nullable=false)
	 */
	protected $status = self::STATUS_FREE;
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * Kapan token ini dibuat.
	 * 
	 * @Orm\Column(name="ENABLED_DATE", type="datetime", nullable=false)
	 */
	protected $enabledDate;
	public function getEnabledDate() {
		return $this->enabledDate;
	}
	public function setEnabledDate($enabledDate) {
		$this->enabledDate = $enabledDate;
	}
	
	/**
	 * @Orm\Column(name="CANCELED_DATE", type="datetime", nullable=true)
	 */
	protected $canceledDate;
	public function getCanceledDate() {
		return $this->canceledDate;
	}
	public function setCanceledDate($canceledDate) {
		$this->canceledDate = $canceledDate;
	}
	
	/**
	 * @Orm\Column(name="CONSUMED_DATE", type="datetime", nullable=true)
	 */
	protected $consumedDate;
	public function getConsumedDate() {
		return $this->consumedDate;
	}
	public function setConsumedDate($consumedDate) {
		$this->consumedDate = $consumedDate;
	}
}