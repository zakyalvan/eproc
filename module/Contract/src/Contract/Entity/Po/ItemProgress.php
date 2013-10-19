<?php
namespace Contract\Entity\Po;

use Doctrine\ORM\Mapping as Orm;

/**
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_PO_ITEM_PERKEMBANGAN")
 *
 * @author zakyalvan
 */
class ItemProgress {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KANTOR", type="string")
	 * @Orm\GeneratedValue(strategy="NONE")
	 *
	 * @var string
	 */
	private $kodeKantor;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KONTRAK", type="string")
	 * @Orm\GeneratedValue(strategy="NONE")
	 *
	 * @var string
	 */
	private $kodeKontrak;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_PO", type="string")
	 * @Orm\GeneratedValue(strategy="NONE")
	 *
	 * @var string
	 */
	private $kodePo;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_PERKEMBANGAN", type="string")
	 * @Orm\GeneratedValue(strategy="NONE")
	 *
	 * @var string
	 */
	private $kodeProgress;
	
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
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Po\Progress", fetch="LAZY", inversedBy="listItemProgress")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_PO", referencedColumnName="KODE_PO"), @Orm\JoinColumn(name="KODE_PERKEMBANGAN", referencedColumnName="KODE_PERKEMBANGAN")})
	 * 
	 * @var Progress
	 */
	private $progress;
	public function getProgress() {
		return $this->progress;
	}
	public function setProgress(Progress $progress) {
		$this->progress = $progress;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Po\Item", fetch="LAZY")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_PO", referencedColumnName="KODE_PO"), @Orm\JoinColumn(name="KODE_PO_ITEM", referencedColumnName="KODE_PO_ITEM")})
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
	 * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalRekam;
	public function getTanggalRekam() {
		return $this->tanggalRekam;
	}
	public function setTanggalRekam(\DateTime $tanggalRekam) {
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
	 * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
	 *
	 * @var \DateTime
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