<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity(repositoryClass="Application\Entity\Repository\GeneratedKeyRepository")
 * @Orm\Table(name="EP_GENERATED_ID")
 * 
 * @author zakyalvan
 */
class GeneratedKey {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_GENERATED_ID", type="integer")
	 * @Orm\GeneratedValue(strategy="SEQUENCE")
	 * @Orm\SequenceGenerator(sequenceName="EP_GENERATED_ID_SEQ")
	 * 
	 * @var integer
	 */
	private $kode;
	
	/**
	 * Context dari key.
	 * 
	 * @Orm\Column(name="TABLE_NAME", type="string")
	 * 
	 * @var string
	 */
	private $context;
	
	/**
	 * Nama dari key
	 * 
	 * @Orm\Column(name="KEY_NAME", type="string")
	 * 
	 * @var string
	 */
	private $key;
	
	/**
	 * Nilai yang digenerate.
	 * 
	 * @Orm\Column(name="GENERATED_VALUE", type="integer")
	 * 
	 * @var integer
	 */
	private $generated;
	
	/**
	 * @Orm\Column(name="GENERATED_DATE", type="datetime")
	 * 
	 * @var \DateTime
	 */
	private $createdDate;
	
	public function __construct($context, $key, $generated) {
		$this->context = $context;
		$this->key = $key;
		$this->generated = $generated;
		$this->createdDate = new \DateTime(null, null);
	}
	
	public function getContext() {
		return $this->context;
	}
	public function getKey() {
		return $this->key;
	}
	public function getGenerated() {
		return $this->generated;
	}
}