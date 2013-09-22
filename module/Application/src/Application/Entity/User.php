<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;
use Zend\Cache\Pattern\ObjectCache;

/**
 * Entity mapping ke user sipt.
 * 
 * @Orm\Entity
 * @Orm\Table(name="SC.SC_USER")
 * 
 * @author zakyalvan
 */
class User {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_USER", type="string")
	 */
	protected $usercode;
	
	/**
	 * @Orm\Column(name="KATA_SANDI", type="string")
	 */
	protected $password;
	
	/**
	 * @Orm\Column(name="NIK", type="string")
	 */
	protected $nik;
	
	/**
	 * @Orm\Column(name="NAMA_USER", type="string")
	 */
	protected $fullname;
	
	/**
	 * @Orm\Column(name="EMAIL", type="string")
	 */
	protected $email;
	
	/**
	 * @Orm\Column(name="AKTIF", type="string")
	 */
	protected $active;
	
	/**
	 * @Orm\Column(name="STATUS", type="string")
	 */
	protected $status;
	
	/**
	 * @Orm\Column(name="TGL_MULAI_STATUS")
	 */
	protected $statusStartDate;
	
	/**
	 * @Orm\Column(name="TGL_AKHIR_STATUS")
	 */
	protected $statusEndDate;
	
	/**
	 * Unit kerja dari user.
	 * 
	 * @Orm\ManyToOne(targetEntity="\Application\Entity\Organization")
	 * @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR")
	 * 
	 * @var Organization
	 */
	protected $organization;
	
	/**
	 * Fungsi-fungsi (atau role) dari user yang bersangkutan.
	 * 
	 * @Orm\ManyToMany(targetEntity="\Application\Entity\Role", inversedBy="users")
	 * @Orm\JoinTable(name="SC.SC_USER_FUNGSI",
 	 * 		joinColumns={@Orm\JoinColumn(name="KODE_USER", referencedColumnName="KODE_USER")},
	 *		inverseJoinColumns={@Orm\JoinColumn(name="KODE_FUNGSI", referencedColumnName="KODE_FUNGSI")}
	 * )
	 */
	protected $roles;
	
	public function getUsercode() {
		return $this->username;
	}
	public function getPassword() {
		return $this->password;
	}
	public function getNik() {
		return $this->nik;
	}
	public function getFullname() {
		return $this->fullname;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getActive() {
		return $this->active;
	}
	public function isActive() {
		return (strtoupper($this->active) == 'Y');
	}
	public function getStatus() {
		return $this->status;
	}
	public function getStatusStartDate() {
		return $this->statusStartDate;
	}
	public function getStatusEndDate() {
		return $this->statusEndDate;
	}
	
	/**
	 * Retrieve data kantor dari user.
	 * 
	 * @return \Application\Entity\Organization
	 */
	public function getOrganization() {
		return $this->organization;
	}
	
	public function getRoles() {
		return $this->roles;
	}
}