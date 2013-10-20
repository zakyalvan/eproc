<?php
namespace Application\Security;

use Application\Entity\User;
use Application\Entity\Role;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Entity\UserRole;

/**
 * Security context untuk penggunaan internal.
 * 
 * @author zakyalvan
 */
class SecurityContext {
	public function __construct(User $loggedinUser, $availableRoles, Role $activeRole = null, \DateTime $loggedinTime = null) {
		$this->loggedinUser = $loggedinUser;
		$this->availableRoles = $availableRoles;
		$this->activeRole = $activeRole;
		$this->loggedinTime = ($loggedinTime == null) ? new \DateTime(null, null) : $loggedinTime;
	}
	
	/**
	 * User yang sedang login.
	 * 
	 * @var User
	 */
	private $loggedinUser;
	public function getLoggedinUser() {
		return $this->loggedinUser;
	}
	
	/**
	 * Daftar role yang valid dari user yang sedang login.
	 * 
	 * @var ArrayCollection
	 */
	private $availableRoles;
	public function getAvailableRoles() {
		return $this->availableRoles;
	}
	
	/**
	 * Role yang sedang aktif digunakan user.
	 * 
	 * @var Role
	 */
	private $activeRole;
	public function getActiveRole() {
		return $this->activeRole;
	}
	public function setActiveRole(Role $activeRole) {
		
		$this->activeRole = $activeRole;
	}
	public function hasActiveRole() {
		return $this->activeRole != null ? true : false;
	}
	
	/**
	 * Kapan user ini login.
	 * 
	 * @var \DateTime
	 */
	private $loggedinTime;
	public function getLoggedinTime() {
		return $this->loggedinTime;
	}
}