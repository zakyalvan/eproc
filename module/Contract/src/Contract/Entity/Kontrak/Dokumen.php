<?php
namespace Contract\Entity\Kontrak;

use Doctrine\ORM\Mapping as Orm;

/**
 * Entity dokumen kontrak.
 * 
 * @Orm\Entity
 * @Orm\Table(name="EP_KTR_KONTRAK_DOK")
 * 
 * @author zakyalvan
 */
class Dokumen {
	const DOKUMEN_KONTRAK_UTAMA = '1';
	const DOKUMEN_LAMPIRAN_A_PERSYARATAN_KHUSUS = '2';
	const DOKUMEN_LAMPIRAN_B_LINGKUP_PEKERJAAN = '3';
	const DOKUMEN_LAMPIRAN_C_HARGA_PEMBAYARAN = '4';
	const DOKUMEN_LAMPIRAN_C_PERSYARATAN_UMUM = '5';
	
	/**
	 * @Orm\ManyToOne(targetEntity="Contract\Entity\Kontrak\Kontrak", fetch="LAZY")
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
     * Kode dokumen
     * 
     * @Orm\Id
     * @Orm\Column(name="KODE_DOKUMEN", type="string")
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
     * @Orm\Column(name="KODE_KATEGORI", type="string", nullable=true)
     *
     * @var string
     */
    private $kodeKategori;
    public function getKodeKategori() {
    	return $this->kodeKategori;
    }
    public function setKodeKategori($kodeKategori) {
    	$this->kodeKategori = $kodeKategori;
    }
    
    /**
     * @Orm\Column(name="KETERANGAN", type="string", nullable=true)
     *
     * @var string
     */
    private $keterangan;
    public function getKeterangan() {
    	return $this->keterangan;
    }
    public function setKeterangan($keterangan) {
    	$this->keterangan = $keterangan;
    }
    
    /**
     * @Orm\Column(name="NAMA_FILE", type="string", nullable=true)
     *
     * @var string
     */
    private $namaFile;
    public function getNamaFile() {
    	return $this->namaFile;
    }
    public function setNamaFile($namaFile) {
    	$this->namaFile = $namaFile;
    }
    
    /**
     * @Orm\Column(name="STATUS", type="string", length=1, nullable=true)
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
     * @Orm\Column(name="STATUS_PUBLISH", type="string", length=1, nullable=true)
     *
     * @var string
     */
    private $statusPublish;
    public function getStatusPublish() {
    	return $this->statusPublish;
    }
    public function setStatusPublish($statusPublish) {
    	$this->statusPublish = $statusPublish;
    } 
    
    /**
     * @Orm\Column(name="TGL_REKAM", type="datetime", nullable=true)
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
     * @Orm\Column(name="TGL_UBAH", type="datetime", nullable=true)
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