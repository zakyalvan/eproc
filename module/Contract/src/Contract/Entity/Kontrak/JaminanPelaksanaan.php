<?php
namespace Contract\Entity\Kontrak;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity jaminan pelaksanaan kontrak. (Ini ngikutin skema lama, entity kontrak mengacu ke table yang sama)
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_KONTRAK")
 * 
 * @author zakyalvan
 */
class JaminanPelaksanaan {
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
	 * @Orm\OneToOne(targetEntity="Contract\Entity\Kontrak\Kontrak", fetch="LAZY", inversedBy="jaminanPelaksanaan")
	 * @Orm\JoinColumns({@Orm\JoinColumn(name="KODE_KONTRAK", referencedColumnName="KODE_KONTRAK"), @Orm\JoinColumn(name="KODE_KANTOR", referencedColumnName="KODE_KANTOR")})
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
	 * @Orm\Column(name="NILAI_JAMINAN", type="float", nullable=true)
	 */
	private $nilaiJaminan;
	public function getNilaiJaminan() {
		return $this->nilaiJaminan;
	}
	public function setNilaiJaminan($nilaiJaminan) {
		$this->nilaiJaminan = $nilaiJaminan;
	}
	
	/**
	 * @Orm\Column(name="BANK_JAMINAN", type="string", nullable=true)
	 */
	private $bankJaminan;
	public function getBankJaminan() {
		return $this->bankJaminan;
	}
	public function setBankJaminan($bankJaminan) {
		$this->bankJaminan = $bankJaminan;
	}
	
	/**
	 * @Orm\Column(name="NO_JAMINAN", type="string", nullable=true)
	 */
	private $nomorJaminan;
	public function getNomorJaminan() {
		return $this->nomorJaminan;
	}
	public function setNomorJaminan($nomorJaminan) {
		$this->nomorJaminan = $nomorJaminan;
	}
	
	/**
	 * @Orm\Column(name="TGL_MULAI_JAMINAN", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalMulaiJaminan;
	public function getTanggalMulaiJaminan() {
		return $this->tanggalMulaiJaminan;
	}
	public function setTanggalMulaiJaminan($tanggalMulaiJaminan) {
		$this->tanggalMulaiJaminan = $tanggalMulaiJaminan;
	}
	
	/**
	 * @Orm\Column(name="TGL_AKHIR_JAMINAN", type="datetime", nullable=true)
	 *
	 * @var \DateTime
	 */
	private $tanggalAkhirJaminan;
	public function getTanggalAkhirJaminan() {
		return $this->tanggalAkhirJaminan;
	}
	public function setTanggalAkhirJaminan($tanggalAkhirJaminan) {
		$this->tanggalAkhirJaminan = $tanggalAkhirJaminan;
	}
	
	/**
	 * @Orm\Column(name="LAMPIRAN_JAMINAN", type="string", nullable=true)
	 */
	private $lampiranJaminan;
	public function getLampiranJaminan() {
		return $this->lampiranJaminan;
	}
	public function setLampiranJaminan($lampiranJaminan) {
		$this->lampiranJaminan = $lampiranJaminan;
	}
}