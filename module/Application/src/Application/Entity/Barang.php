<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity(readOnly=true)
 * @Orm\Table(name="EP_VIEW_BARANG")
 * 
 * @author zakyalvan
 */
class Barang {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_BARANG", type="string")
	 * 
	 * @var string
	 */
	private $kode;
	public function getKode() {
		return $this->kode;
	}
	
	/**
	 * @Orm\Column(name="NAMA_BARANG", type="string", nullable=false)
	 * 
	 * @var string
	 */
	private $nama;
	public function getNama() {
		return $this->nama;
	}
}