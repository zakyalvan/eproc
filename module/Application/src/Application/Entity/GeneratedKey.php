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
	 * @Orm\GeneratedValue(strategy="SEQUENCE")
	 * @Orm\SequenceGenerator(name="EP_GENERATED_ID_SEQ")
	 * 
	 * @var integer
	 */
	private $id;
	
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
	
	public function __construct($context, $key, $generated) {
		$this->context = $context;
		$this->key = $key;
		$this->generated = $generated;
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