<?php
namespace Procurement\Entity\Tender;

use Doctrine\ORM\Mapping as Orm;
use Vendor\Entity\Vendor;

/**
 * Table mapping (many-to-many) antara vendor dengan tender.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_PGD_TENDER_VENDOR")
 * 
 * @author zakyalvan
 */
class TenderVendor {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_TENDER", type="string")
	 *
	 * @var string
	 */
	private $kodeTender;
	
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_KANTOR", type="string")
	 *
	 * @var string
	 */
	private $kodeKantor;
	
	/**
	 * @Orm\ManyToOne(targetEntity="Procurement\Entity\Tender\Tender", fetch="LAZY", inversedBy="tenderVendors")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_TENDER", referencedColumnName="KODE_TENDER"), @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR")})
	 *
	 * @var Tender
	 */
	private $tender;
	public function getTender() {
		return $this->tender;
	}
	public function setTender(Tender $tender) {
		$this->tender = $tender;
	}
	
	/**
	 * @Orm\Id
	 * @Orm\ManyToOne(targetEntity="Vendor\Entity\Vendor", fetch="LAZY")
	 * @Orm\JoinColumn(name="KODE_VENDOR", referencedColumnName="KODE_VENDOR")
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
	 * @Orm\OneToOne(targetEntity="Procurement\Entity\Tender\Penawaran", fetch="LAZY", mappedBy="tenderVendor")
	 *
	 * @var Penawaran
	 */
	private $penawaran;
	public function getPenawaran() {
		return $this->penawaran;
	}
	public function setPenawaran(Penawaran $penawaran) {
		$this->penawaran = $penawaran;
	}
	
	/**
	 * @Orm\OneToOne(targetEntity="Procurement\Entity\Tender\VendorStatus", fetch="LAZY", mappedBy="tenderVendor")
	 * 
	 * @var VendorStatus
	 */
	private $vendorStatus;
	public function getVendorStatus() {
		return $this->vendorStatus;
	}
	public function setVendorStatus(VendorStatus $vendorStatus) {
		$this->vendorStatus = $vendorStatus;
	}
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
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
	 */
	private $petugasRekam;
	public function getPetugasRekam() {
		return $this->petugasRekam;
	}
	public function setPetugasRekam($petugasRekam) {
		$this->petugasRekam = $petugasRekam;
	}
	
	/**
	 * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
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
	 */
	private $petugasUbah;
	public function getPetugasUbah() {
		return $this->petugasUbah;
	}
	public function setPetugasUbah($petugasUbah) {
		$this->petugasUbah = $petugasUbah;
	}
}