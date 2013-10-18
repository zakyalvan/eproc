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
	public function __construct(User $loggedinUser, Role $activeRole = null) {
		$this->loggedinUser = $loggedinUser;
		$this->availableRoles = new ArrayCollection();
		
		foreach ($loggedinUser->getListUserRole() as $userRole) {
			$this->availableRoles->add($userRole->getRole());
		}
		
		$this->activeRole = $activeRole;
		$this->loggedinTime = new \DateTime(null, null);
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
	 * @var ArrayCollection
	 */
	private $availableRoles;
	public function getAvailableRoles() {
		return $this->availableRoles;
	}
	public function setAvailableRoles($availableRoles) {
		$this->availableRoles = $availableRoles;
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
	 * 
	 * @var \DateTime
	 */
	private $loggedinTime;
	public function getLoggedinTime() {
		return $this->loggedinTime;
	}
}