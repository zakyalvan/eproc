<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity(readOnly=true)
 * @Orm\Table(name="EP_KOM_JASA")
 * 
 * @author zakyalvan
 */
class Jasa {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_JASA")
	 * 
	 * @var string
	 */
	private $kode;
	public function getKode() {
		return $this->kode;
	}
	
	/**
	 * @Orm\Column(name="NAMA_JASA")
	 * 
	 * @var string
	 */
	private $nama;
	public function getNama() {
		return $nama;
	}
}