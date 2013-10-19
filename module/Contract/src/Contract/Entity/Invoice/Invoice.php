<?php
namespace Contract\Entity\Invoice;

use Doctrine\ORM\Mapping as Orm;
use Vendor\Entity\Vendor;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Entity header dari invoice invoice
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_INVOICE")
 * 
 * @author zakyalvan
 */
class Invoice {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KONTRAK", type="string")
	 * 
	 * @var string
	 */
	private $kodeKontrak;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KANTOR", type="string")
	 * 
	 * @var string
	 */
	private $kodeKantor;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_INVOICE", type="string", length=50)
	 * 
	 * @var string
	 */
	private $kode;
	public function getKode() {
		return $this->kode;
	}
	public function setKode($kode) {
		$this->kode = $kode;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Kontrak")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", referencedColumnName="KODE_KONTRAK")})
	 *
	 * @var Kontrak
	 */
	private $kontrak;
	public function getKontrak() {
		return $this->kontrak;
	}
	public function setKontrak(Kontrak $kontrak) {
		$this->kontrak = $kontrak;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Vendor\Entity\Vendor", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_VENDOR", type="integer", referencedColumnName="KODE_VENDOR")
	 *
	 * @var Vendor
	 */
	private $vendor;
	public function getVendor() {
		return $this->vendor;
	}
	public function setVendor(Vendor $vendor) {
		$this->vendor = $vendor;
	}
	
	/**
	 * @Column(name="TGL_INVOICE", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalInvoice;
	public function getTanggalInvoice() {
		return $this->tanggalInvoice;
	}
	public function setTanggalInvoice($tanggalInvoice) {
		$this->tanggalInvoice = $tanggalInvoice;
	}
	
	/**
	 * @Column(name="NAMA_VENDOR", type="string", length=250, nullable=true)
	 *
	 * @var string
	 */
	private $namaVendor;
	public function getNamaVendor() {
		return $this->namaVendor;
	}
	public function setNamaVendor($namaVendor) {
		$this->namaVendor = $namaVendor;
	}
	
	/**
	 * @Column(name="AKUN_BANK", type="string", length=200, nullable=true)
	 *
	 * @var string
	 */
	private $akunBank;
	public function getAkunBank() {
		return $this->akunBank;
	}
	public function setAkunBank($akunBank) {
		$this->akunBank = $akunBank;
	}
	
	/**
	 * @Column(name="TGL_BUAT", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalPembuatan;
	public function getTanggalPembuatan() {
		return $this->tanggalPembuatan;
	}
	public function setTanggalPembuatan($tanggalPembuatan) {
		$this->tanggalPembuatan = $tanggalPembuatan;
	}
	
	/**
	 * @Column(name="STATUS", type="string", length=2, nullable=true)
	 *
	 * @var string
	 */
	private $status;
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * @Column(name="POSISI_PERSETUJUAN", type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $posisiPersetujuan;
	public function getPosisiPersetujuan() {
		return $this->posisiPersetujuan;
	}
	public function setPosisiPersetujuan($posisiPersetujuan) {
		$this->posisiPersetujuan = $posisiPersetujuan;
	}
	
	/**
	 * @Column(name="TGL_DISETUJUI", type="datetime", nullable=true)
	 * 
	 * @var \DateTime
	 */
	private $tanggalDisetujui;
	public function getTanggalDisetujui() {
		return $this->tanggalDisetujui;
	}
	public function setTanggalDisetujui(\DateTime $tanggalDisetujui) {
		$this->tanggalDisetujui = $tanggalDisetujui;
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Contract\Entity\Invoice\Dokumen", fetch="LAZY", mappedBy="invoice")
	 * 
	 * @var ArrayCollection
	 */
	private $listDokumen;
	public function getListDokumen() {
		return $this->listDokumen;
	}
	public function setListDokumen(ArrayCollection $listDokumen) {
		$this->listDokumen = $listDokumen;
	}
	public function addListDokumen(ArrayCollection $listDokumen) {
		foreach ($listDokumen as $dokumen) {
			$this->listDokumen->add($dokumen);
		}
	}
	public function removeListDokumen(ArrayCollection $listDokumen) {
		foreach ($listDokumen as $dokumen) {
			if($this->listDokumen->contains($dokumen)) {
				$this->listDokumen->remove($this->listDokumen->indexOf($dokumen));
			}
		}
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Contract\Entity\Invoice\Item", fetch="LAZY", mappedBy="invoice")
	 * 
	 * @var ArrayCollection
	 */
	private $listItem;
	public function getListItem() {
		return $this->listItem;
	}
	public function setListItem(ArrayCollection $listItem) {
		$this->listItem = $listItem;
	}
	public function addListItem(ArrayCollection $listItem) {
		foreach ($listItem as $item) {
			$this->listItem->add($item);
		}
	}
	public function removeListItem(ArrayCollection $listItem) {
		foreach ($listItem as $item) {
			if($this->listItem->contains($item)) {
				$this->listItem->remove($this->listItem->indexOf($item));
			}
		}	
	}
	
	/**
	 * @Orm\OneToMany(targetEntity="Contract\Entity\Invoice\Komentar", fetch="LAZY", mappedBy="invoice")
	 * 
	 * @var ArrayCollection
	 */
	private $listKomentar;
	public function getListKomentar() {
		return $this->listKomentar;
	}
	public function setListKomentar(ArrayCollection $listKomentar) {
		$this->listKomentar = $listKomentar;
	}
	public function addListKomentar(ArrayCollection $listKomentar) {
		foreach ($listKomentar as $komentar) {
			$this->listKomentar->add($komentar);
		}
	}
	public function removeListKomentar(ArrayCollection $listKomentar) {
		foreach ($listKomentar as $komentar) {
			if($this->listKomentar->contains($komentar)) {
				$this->listKomentar->remove($this->listKomentar->indexOf($komentar));
			}
		}
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
	 * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalUbah;
	public function getTanggalUbah() {
		return $this->tanggalUbah;
	}
	public function setTanggalUbah(\DateTime $tanggalUbah) {
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
	public function setPetugasUbah(\DateTime $petugasUbah) {
		$this->petugasUbah = $petugasUbah;
	}
}