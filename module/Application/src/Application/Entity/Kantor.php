<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;
/**
 * Kelas entity yang menyimpan informasi kantor.
 * 
 * @Orm\Entity(repositoryClass="Application\Entity\Repository\KantorRepository")
 * @Orm\Table(name="SC.MS_KANTOR")
 * 
 * @author zakyalvan
 */
class Kantor {
	/**
	 * Kode unit kerja.
	 * 
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KANTOR", type="string")
	 * @Orm\GeneratedValue(strategy="NONE")
	 */
	protected $kode;
	public function getKode() {
		return $this->kode;
	}
	
	/**
	 * @Orm\Column(name="NAMA_KANTOR", type="string")
	 */
	protected $nama;
	public function getNama() {
		return $this->nama;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Application\Entity\Kantor", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_KANTOR_INDUK", referencedColumnName="KODE_KANTOR")
	 * 
	 * @var Kantor
	 */
	protected $kantorInduk;
	public function getKantorInduk() {
		return $this->kantorInduk;
	}
	
	/**
	 * List user dalam organisasi ini.
	 */
	protected $users;
	public function getUsers() {
		return $this->users;
	}
}