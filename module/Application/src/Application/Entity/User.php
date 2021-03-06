<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Cache\Pattern\ObjectCache;

/**
 * Entity mapping ke user sipt.
 * 
 * @Orm\Entity(repositoryClass="Application\Entity\Repository\UserRepository", readOnly=true)
 * @Orm\Table(name="SC.SC_USER")
 * 
 * @author zakyalvan
 */
class User {
	public function __construct() {
		$this->listUserRole = new ArrayCollection();
	}
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_USER", type="string")
	 * @Orm\GeneratedValue(strategy="NONE")
	 * 
	 * @var string
	 */
	protected $kode;
	public function getKode() {
		return $this->kode;
	}
	
	/**
	 * @Orm\Column(name="KATA_SANDI", type="string")
	 */
	protected $password;
	public function getPassword() {
		return $this->password;
	}
	
	/**
	 * @Orm\Column(name="NIK", type="string", nullable=true)
	 */
	protected $nik;
	public function getNik() {
		return $this->nik;
	}
	
	/**
	 * Nama lengkap dari user.
	 * 
	 * @Orm\Column(name="NAMA_USER", type="string", nullable=true)
	 */
	protected $nama;
	public function getNama() {
		return $this->nama;
	}
	
	/**
	 * @Orm\Column(name="EMAIL", type="string", nullable=true)
	 */
	protected $email;
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * @Orm\Column(name="AKTIF", type="string", nullable=true)
	 */
	protected $aktif;
	public function getAktif() {
		return $this->aktif;
	}
	public function isAktif() {
		return (strtoupper($this->aktif) == 'Y') ? true : false;
	}
	
	/**
	 * @Orm\Column(name="STATUS", type="string")
	 */
	protected $status;
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 * @Orm\Column(name="TGL_MULAI_STATUS", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	protected $tanggalMulaiStatus;
	public function getTanggalMulaiStatus() {
		return $this->tanggalMulaiStatus;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR_STATUS", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	protected $tanggalAkhirStatus;
	public function getTanggalAkhirStatus() {
		return $this->tanggalAkhirStatus;
	}
	
	/**
	 * Unit kerja dari user.
	 * 
	 * @Orm\ManyToOne(targetEntity="\Application\Entity\Kantor", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR")
	 * 
	 * @var Kantor
	 */
	protected $kantor;
	public function getKantor() {
		return $this->kantor;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Application\Entity\UserRole", fetch="LAZY", mappedBy="user")
	 *
	 * @var ArrayCollection
	 */
	protected $listUserRole;
	public function getListUserRole() {
		return $this->listUserRole;
	}
	
	public function __toString() {
		return $this->nama;
	}
}