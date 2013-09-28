<?php
namespace Contract\Entity\Amend;

use Doctrine\ORM\Mapping;

/**
 * Jaminan pelaksanaan perubahan
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PERUBAHAN_JAMINAN_PEL")
 * 
 * @author zakyalvan
 */
class JaminanPelaksanaan {
	/**
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Perubahan\Perubahan")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_PERUBAHAN", type="integer", referencedColumnName="KODE_PERUBAHAN"), @Orm\JoinColumn(name="KODE_KANTOR", type="string", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", referencedColumnName="KODE_KONTRAK")})
	 *
	 * @var Perubahan
	 */
	private $perubahan;
}