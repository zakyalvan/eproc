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
	 * @Orm\ManyToOne(targetEntity="Procurement\Entity\Tender\Tender", fetch="lazy", inversedBy="tenderVendors")
	 * @Orm\JoinColumns({@JoinColumn(name="KODE_TENDER", type="string", referencedColumnName="KODE_TENDER"), @JoinColumn(name="KODE_KANTOR", type="string", referencedColumnName="KODE_KANTOR")})
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
	 * @Orm\ManyToOne(targetEntity="Vendor\Entity\Vendor", fetch="lazy")
	 * @Orm\JoinColumn(name="KODE_VENDOR", type="string", referencedColumnName="KODE_VENDOR")
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
	 * @Orm\OneToOne(targetEntity="Procurement\Entity\Tender\VendorStatus", mappedBy="tenderVendor")
	 * 
	 * @var VendorStatus
	 */
	private $vendorStatus;
	
	/**
	 * @Orm\Column(name="TGL_REKAM", type="date", nullable=true)
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
	 * @Orm\Column(name="TGL_UBAH", type="date", nullable=true)
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