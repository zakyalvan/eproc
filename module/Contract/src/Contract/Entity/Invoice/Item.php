<?php
namespace Contract\Entity\Invoice;

use Doctrine\ORM\Mapping as Orm;
use Application\Entity\MataUang;

/**
 * Item detail dari invoice.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_INVOICE_ITEM")
 * 
 * @author zakyalvan
 */
class Item  {
	/**
	 * @Orm\Id
	 * @Orm\Column(name="KODE_ITEM", type="integer", length="64")
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
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Invoice\Invoice")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KANTOR", type="string", length="5", referencedColumnName="KODE_KANTOR"), @Orm\JoinColumn(name="KODE_KONTRAK", type="string", length="50", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_INVOICE", type="string", length="50", referencedColumnName="KODE_INVOICE"), @Orm\JoinColumn(name="KODE_VENDOR", type="integer", referencedColumnName="KODE_VENDOR")})
	 *
	 * @var Invoice
	 */
	private $invoice;
	public function getInvoice() {
		return $this->invoice;
	}
	public function setInvoice(Invoice $invoice) {
		$this->invoice = $invoice;
	}
	
	/**
	 * @Orm\Column(name="NO_BASTP", type="string", length="50", nullable=true)
	 * 
	 * @var string
	 */
	private $nomorBastp;
	public function getNomorBastp() {
		return $this->nomorBastp;
	}
	public function setNomorBastp($nomorBastp) {
		$this->nomorBastp = $nomorBastp;
	}
	
	/**
	 * @Orm\Column(name="NILAI_BASTP", type="double", nullable=true)
	 *
	 * @var double
	 */
	private $nilaiBastp;
	public function getNilaiBastp() {
		return $this->nilaiBastp;
	}
	public function setNilaiBastp($nilaiBastp) {
		$this->nilaiBastp = $nilaiBastp;
	}
	
	/**
	 * @Orm\ManyToOne(targetEntity="Master\Entity\MataUang", fetch="eager")
	 * @Orm\JoinColumn(name="MATA_UANG_BASTP", type="string", nullable=true, referencedColumnName="MATA_UANG")
	 *
	 * @var MataUang
	 */
	private $mataUangBastp;
	public function getMataUangBastp() {
		return $this->mataUangBastp;
	}
	public function setMataUangBastp(MataUang $mataUangBastp) {
		$this->mataUangBastp = $mataUangBastp;
	}
	
	/**
	 * @Orm\Column(name="PENALTI_BASTP", type="double", nullable=true)
	 *
	 * @var double
	 */
	private $penaltiBastp;
	public function getPenaltiBastp() {
		return $this->penaltiBastp;
	}
	public function setPenaltiBastp($penaltiBastp) {
		$this->penaltiBastp = $penaltiBastp;
	}
	
	/**
	 * @Orm\Column(name="PPH23_BASTP", type="double", nullable=true)
	 *
	 * @var double
	 */
	private $pph23Bastp;
	public function getPph23Bastp() {
		return $this->pph23Bastp;
	}
	public function setPph23Bastp($pph23Bastp) {
		$this->pph23Bastp = $pph23Bastp;
	}
	
	/**
	 * @Orm\Column(name="PPN_BASTP", type="double", nullable=true)
	 *
	 * @var double
	 */
	private $ppnBastp;
	public function getPpnBastp() {
		return $this->ppnBastp;
	}
	public function setPpnBastp($ppnBastp) {
		$this->ppnBastp = $ppnBastp;
	}
	
	/**
	 * @Orm\Column(name="DP_BASTP", type="double", nullable=true)
	 *
	 * @var double
	 */
	private $uangMukaBastp;
	public function getUangMukaBastp() {
		return $this->uangMukaBastp;
	}
	public function setUangMukaBastp($uangMukaBastp) {
		$this->uangMukaBastp = $uangMukaBastp;
	}
	
	/**
	 * @Orm\Column(name="SUBTOTAL_BASTP", type="double",nullable=true)
	 *
	 * @var double
	 */
	private $subTotalBastp;
	public function getSubTotalBastp() {
		return $this->subTotalBastp;
	}
	public function setSubTotalBastp($subTotalBastp) {
		$this->subTotalBastp = $subTotalBastp;
	}
	
	/**
	 * @Orm\Column(name="KETERANGAN_BASTP", type="string", length="4000", nullable=true)
	 *
	 * @var string
	 */
	private $keteranganBastp;
	public function getKetaranganBastp() {
		return $this->keteranganBastp;
	}
	public function setKetaranganBastp($keteranganBastp) {
		$this->keteranganBastp = $keteranganBastp;
	}
	
	/**
	 * @Orm\Column(name="KOMENTAR_BASTP", type="string", length="4000", nullable=true)
	 *
	 * @var string
	 */
	private $komentarBastp;
	public function getKomentarBastp() {
		return $this->komentarBastp;
	}
	public function setKomentarBastp($komentarBastp) {
		$this->komentarBastp = $komentarBastp;
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