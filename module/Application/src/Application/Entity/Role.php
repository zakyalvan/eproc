<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity yang nyimpan user fungsi, dari sipt.
 * 
 * @Orm\Entity
 * @Orm\Table(name="SC.SC_FUNGSI")
 * 
 * @author zakyalvan
 */
class Role {
	/**
	 * Kode fungsi.
	 * 
	 * @Orm\Id
	 * @Orm\Column(name="KODE_FUNGSI", type="string")
	 */
	protected $code;
	
	/**
	 * @Orm\Column(name="NAMA_FUNGSI", type="string")
	 */
	protected $name;
	
	/**
	 * Inisial atau akronim untuk fungsi ini.
	 * 
	 * @Orm\Column(name="INISIAL_FUNGSI", type="string")
	 */
	protected $acronym;
	
	/**
	 * Status aktif atau tidak.
	 * 
	 * @Orm\Column(name="AKTIF", type="string")
	 */
	protected $active;
	
	/**
	 * Kolom keterangan
	 * 
	 * @orm\Column(name="KETERANGAN", type="string")
	 */
	protected $note;
	
	/**
	 * @Orm\ManyToMany(targetEntity="\Application\Entity\User", inversedBy="roles")
	 */
	protected $users;
	
	public function getCode() {
		return $this->code;
	}
	public function getName() {
		return $this->name;
	}
	public function getAcronym() {
		return $this->acronym;
	}
	public function getActive() {
		return $this->active;
	}
	public function isActive() {
		return ($this->active == 'Y' ? true : false);
	}
	public function getNote() {
		return $this->note;
	}
}