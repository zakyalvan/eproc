<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;
use Doctrine\Common\Collections\ArrayCollection;

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
	 * Kode fungsi/role.
	 * 
	 * @Orm\Id
	 * @Orm\Column(name="KODE_FUNGSI", type="string")
	 * @Orm\GeneratedValue(strategy="NONE")
	 * 
	 * @var string
	 */
	protected $kode;
	public function getKode() {
		return $this->kode;
	}
	
	/**
	 * Nama fungsi/role.
	 * 
	 * @Orm\Column(name="NAMA_FUNGSI", type="string")
	 */
	protected $nama;
	public function getNama() {
		return $this->nama;
	}
	
	/**
	 * Inisial atau akronim untuk fungsi/role.
	 * 
	 * @Orm\Column(name="INISIAL_FUNGSI", type="string")
	 */
	protected $inisial;
	public function getInisial() {
		return $this->inisial;
	}
	
	/**
	 * Status aktif atau tidak.
	 * 
	 * @Orm\Column(name="AKTIF", type="string", nullable=true)
	 */
	protected $aktif;
	public function getAktif() {
		return $this->aktif;
	}
	
	/**
	 * Kolom keterangan
	 * 
	 * @Orm\Column(name="KETERANGAN", type="string", nullable=true)
	 */
	protected $keterangan;
	public function getKeterangan() {
		return $this->keterangan;
	}
	
	/**
	 * List user yang berada dalam role ini.
	 * 
	 * @Orm\ManyToMany(targetEntity="Application\Entity\User", mappedBy="roles")
	 */
	protected $users;
	public function getUsers() {
		return $this->users;
	}
}