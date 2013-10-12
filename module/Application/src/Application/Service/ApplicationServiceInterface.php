<?php
namespace Application\Service;

use Application\Entity\User;
interface ApplicationServiceInterface {
	/**
	 * 
	 * @param unknown $kode
	 * @return User
	 */
	public function getOneUserByKode($kode);
	
	/**
	 * 
	 * @param unknown $role
	 * @param unknown $kantor
	 */
	public function getListUserByRole($role, $kantor);
}