<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity master jabatan.
 * 
 * @Orm\Entity(readOnly=true)
 * @Orm\Table(name="SC.MS_JABATAN")
 * 
 * @author zakyalvan
 */
class Jabatan {
	private $kode;
}