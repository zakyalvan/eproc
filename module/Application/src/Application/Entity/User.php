<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Cache\Pattern\ObjectCache;

/**
 * Entity mapping ke user sipt.
 * 
 * @Orm\Entity(repositoryClass="Application\Entity\Repository\UserRepository")
 * @Orm\Table(name="SC.SC_USER")
 * 
 * @author zakyalvan
 */
class User {
	public function __construct() {
		$this->roles = new ArrayCollection();
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
	 * @Orm\Column(name="TGL_MULAI_STATUS", type="date", nullable=true)
	 */
	protected $tanggalMulaiStatus;
	public function getTanggalMulaiStatus() {
		return $this->tanggalMulaiStatus;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR_STATUS", type="date", nullable=true)
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
	 * Fungsi-fungsi (atau role) dari user yang bersangkutan.
	 * 
	 * @Orm\ManyToMany(targetEntity="\Application\Entity\Role", inversedBy="users")
	 * @Orm\JoinTable(name="SC.SC_USER_FUNGSI",
 	 * 		joinColumns={@Orm\JoinColumn(name="KODE_USER", referencedColumnName="KODE_USER")},
	 *		inverseJoinColumns={@Orm\JoinColumn(name="KODE_FUNGSI", referencedColumnName="KODE_FUNGSI")}
	 * )
	 * 
	 * @var ArrayCollection
	 */
	protected $roles;
	public function getRoles() {
		return $this->roles;
	}
}