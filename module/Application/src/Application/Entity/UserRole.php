<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Table mapping antara user dengan role.
 * 
 * @Orm\Entity(readOnly=true)
 * @Orm\Table(name="SC.SC_USER_FUNGSI")
 * 
 * @author zakyalvan
 */
class UserRole {
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="EAGER", inversedBy="listUserRole")
	 * @Orm\JoinColumn(name="KODE_USER", referencedColumnName="KODE_USER")
	 * 
	 * @var User
	 */
	private $user;
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Role", fetch="EAGER", inversedBy="listUserRole")
	 * @Orm\JoinColumn(name="KODE_FUNGSI", referencedColumnName="KODE_FUNGSI")
	 *
	 * @var Role
	 */
	private $role;
	public function getRole() {
		return $this->role;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Kantor", fetch="EAGER")
	 * @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR")
	 *
	 * @var Kantor
	 */
	private $kantor;
	public function getKantor() {
		return $this->kantor;
	}
}