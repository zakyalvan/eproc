<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;
/**
 * Kelas entity yang menyimpan informasi kantor.
 * 
 * @Orm\Entity
 * @Orm\Table(name="SC.MS_KANTOR")
 * 
 * @author zakyalvan
 */
class Organization {
	/**
	 * Kode unit kerja.
	 * 
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KANTOR", type="string")
	 * @Orm\GeneratedValue(strategy="NONE")
	 */
	protected $code;
	
	/**
	 * @Orm\Column(name="NAMA_KANTOR", type="string")
	 */
	protected $name;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Organization", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_KANTOR_INDUK", referencedColumnName="KODE_KANTOR")
	 * 
	 * @var Organization
	 */
	protected $parent;
	
	/**
	 * List user dalam organisasi ini.
	 */
	protected $users;
	
	public function getCode() {
		return $this->code;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getParent() {
		return $this->parent;
	}
	
	public function getUsers() {
		return $this->users;
	}
}