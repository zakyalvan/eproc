<?php
namespace Contract\Entity\Perubahan;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PERUBAHAN_ITEM")
 * 
 * @author zakyalvan
 */
class Item {
	/**
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Perubahan\Perubahan")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_PERUBAHAN", type="integer", referencedColumnName="KODE_PERUBAHAN"), @Orm\JoinColumn(name="KODE_KANTOR", type="string", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", referencedColumnName="KODE_KONTRAK")})
	 * 
	 * @var Perubahan
	 */
	private $perubahan;
	
	private $item;
}