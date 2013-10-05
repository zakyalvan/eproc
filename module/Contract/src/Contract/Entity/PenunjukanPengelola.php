<?php
namespace Contract\Entity;

use Doctrine\ORM\Mapping as Orm;
use Procurement\Entity\Tender\Tender;
use Contract\Entity\Kontrak\Kontrak;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PENUNJUKAN_PENGELOLA")
 * 
 * @author zakyalvan
 */
class PenunjukanPengelola {
	const STATUS_PENUNJUKAN = 'PENUNJUKAN';
	const STATUS_PERGANTIAN = 'PERGANTIAN';
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_PENUNJUKAN", type="integer")
	 * @Orm\GeneratedValue(strategy="NONE")
	 * 
	 * @var integer
	 */
	private $kode;
	
	/**
	 * @var Tender
	 */
	private $tender;
	
	/**
	 * @var Kontrak
	 */
	private $kontrak;
	
	private $kodePengelola;
	private $namaPengelola;
	private $status;
	private $tanggalBuat;
	private $petugasBuat;
	private $tanggalUbah;
}