<?php
namespace Contract\Entity\Po;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PO_ITEM_PERKEMBANGAN")
 *
 * @author zakyalvan
 */
class ItemPerkembangan {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_ITEM_PERKEMBANGAN", type="integer")
	 * @Orm\GeneratedValue(strategy="NONE")
	 * 
	 * @var integer
	 */
	private $kode;
	public function getKode() {
		return $this->kode;
	}
	public function setKode($kode) {
		$this->kode = $kode;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Po\Perkembangan", fetch="lazy")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", type="string", length="5", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", length="50", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_PO", type="string", length="50", referencedColumnName="KODE_PO"), @Orm\JoinColumn(name="KODE_PERKEMBANGAN", type="integer", referencedColumnName="KODE_PERKEMBANGAN")})
	 * 
	 * @var Perkembangan
	 */
	private $perkembangan;
	public function getPerkembangan() {
		return $this->perkembangan;
	}
	public function setPerkembangan(Perkembangan $perkembangan) {
		$this->perkembangan = $perkembangan;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Po\Item", fetch="lazy")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", type="string", length="5", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", length="50", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_PO", type="string", length="50", referencedColumnName="KODE_PO"), @Orm\JoinColumn(name="KODE_PO_ITEM", type="integer", referencedColumnName="KODE_PO_ITEM")})
	 * 
	 * @var Item
	 */
	private $item;
	public function getItem() {
		return $this->item;
	}
	public function setItem(Item $item) {
		$this->item = $item;
	}
	
	/**
	 * @Orm\Column(name="QTY_PERKEMBANGAN", type="integer", nullable=false)
	 * 
	 * @var integer
	 */
	private $quantityPerkembangan;
	public function getQuantityPerkembangan() {
		return $this->quantityPerkembangan;
	}
	public function setQuantityPerkembangan($quantityPerkembangan) {
		$this->quantityPerkembangan = $quantityPerkembangan;
	}
	
	/**
	 * @Orm\Column(name="QTY_DISETUJUI", type="integer", nullable=false)
	 *
	 * @var integer
	 */
	private $quantityDisetujui;
	public function getQuantityDisetujui() {
		return $this->quantityDisetujui;
	}
	public function setQuantityDisetujui($quantityDisetujui) {
		$this->quantityDisetujui = $quantityDisetujui;
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="date", nullable=true)
	 *
	 * @var date
	 */
	private $tanggalRekam;
	public function getTanggalRekam() {
		return $this->tanggalRekam;
	}
	public function setTanggalRekam($tanggalRekam) {
		$this->tanggalRekam = $tanggalRekam;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_REKAM", type="string", nullable=true)
	 *
	 * @var string
	 */
	private $petugasRekam;
	public function getPetugasRekam() {
		return $this->petugasUbah;
	}
	public function setPetugasRekam($petugasRekam) {
		$this->petugasRekam = $petugasRekam;
	}
	
	/**
	 * @Orm\Column(name="TGL_UBAH", type="date", nullable=true)
	 *
	 * @var date
	 */
	private $tanggalUbah;
	public function getTanggalUbah() {
		return $this->tanggalUbah;
	}
	public function setTanggalUbah($tanggalUbah) {
		$this->tanggalUbah = $tanggalUbah;
	}
	
	/**
	 * @Orm\Column(name="PETUGAS_UBAH", type="string", nullable=true)
	 *
	 * @var string
	 */
	private $petugasUbah;
	public function getPetugasUbah() {
		return $this->petugasUbah;
	}
	public function setPetugasUbah($petugasUbah) {
		$this->petugasUbah = $petugasUbah;
	}
}