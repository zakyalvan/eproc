<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Mapping antara kantor-user-pejabat.
 * 
 * @Orm\Entity(readOnly=true)
 * @Orm\Table(name="SC.MS_PEJABAT_KANTOR")
 * 
 * @author zakyalvan
 */
class MappingPejabatKantor {
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Application\Entity\User", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_USER", referencedColumnName="KODE_USER")
	 * 
	 * @var User
	 */
	private $user;
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Jabatan", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_JABATAN", referencedColumnName="KODE_JABATAN")
	 * 
	 * @var Jabatan
	 */
	private $jabatan;
	public function getJabatan() {
		return $this->jabatan;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Kantor", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR")
	 * 
	 * @var Kantor
	 */
	private $kantor;
	public function getKantor() {
		return $this->kantor;
	}
}