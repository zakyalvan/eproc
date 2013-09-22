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
	 */
	protected $code;
	
	/**
	 * @Orm\Column(name="NAMA_KANTOR", type="string")
	 */
	protected $name;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Organization", fetch="LAZY")
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
	
	/**
	 * @return \Application\Entity\Organization
	 */
	public function getParent() {
		return $this->parent;
	}
	
	public function getUsers() {
		return $this->users;
	}
}