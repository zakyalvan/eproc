<?php
namespace Application\Entity\Repository;

use Application\Entity\Kantor;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Repository untuk kantor.
 * 
 * @author zakyalvan
 */
class KantorRepository extends EntityRepository {
	/**
	 * Retrieve jenis dari sebuah kantor, apakah unit kantor pusat, kantor wilayah atau kantor cabang.
	 * 
	 * @param Kantor|string $kantor
	 * @return integer
	 */
	public function getJenisKantor($kantor) {
		$kodeKantor = null;
		if($kantor instanceof Kantor) {
			$kodeKantor = $kantor->getKode();
		}
		if(is_string($kantor)) {
			$kodeKantor = $kantor;
		}
		else {
			throw new \InvalidArgumentException(sprintf('Parameter kantor harus berupa object dari kelas Application\Entity\Kantor atau string kode kantor'), 100, null);
		}
		
		if(!$this->_em->find($this->_class->getName(), $kodeKantor)) {
 			throw new \InvalidArgumentException(sprintf('Data kantor dengan kode %s tidak ditemukan dalam database', $kodeKantor), 100, null);
		}
		
		$jenisKantor = null;
		
		/**
		 * Flag untuk nandain bahwa jenis kantor ditemukan lebih dari satu (berarti query masih salah).
		 * Untuk nentuin kode kantor diiterasi untuk semua jenis kantor (pusat, wilayah, dan cabang).
		 */
		$jenisKantorGanda = false;
		
		foreach ($this->findUnitKerjaPusat() as $kantorPusat) {
			if($kodeKantor == $kantorPusat->getKode()) {
				$jenisKantor = Kantor::UNIT_KERJA_KANTOR_PUSAT;
			}
		}
		foreach ($this->findUnitKerjaWilayah() as $kantorWilayah) {
			if($kodeKantor == $kantorWilayah->getKode()) {
				if($jenisKantor) {
					$jenisKantorGanda = true;
				}
				$jenisKantor = Kantor::UNIT_KERJA_KANTOR_WILAYAH;
			}
		}
		foreach ($this->findUnitKerjaCabang() as $kantorCabang) {
			if($kodeKantor == $kantorCabang->getKode()) {
				if($jenisKantor) {
					$jenisKantorGanda = true;
				}
				$jenisKantor = Kantor::UNIT_KERJA_KANTOR_CABANG;
			}
		}
		
 		if($jenisKantorGanda) {
 			throw new \RuntimeException(sprintf('Jenis kantor dengan kode %d ditemukan ganda. Harus ada koreksi dalam query database', $kodeKantor), 100, null);
 		}
		
		return $jenisKantor;
	}
	
	/**
	 * List unit kerja-unit unit-kerja (biro/divisi) yang ada di kantor pusat.
	 */
	public function findUnitKerjaPusat() {
		$queryString = "
			SELECT 
				{$this->_class->getColumnName('kode')} AS \"kode\",
				{$this->_class->getColumnName('nama')} AS \"nama\"
			FROM 
				{$this->_class->getTableName()}
			WHERE 
				KODE_KANTOR_INDUK = 'P'
				AND KODE_KANTOR <> 'ATP'
			ORDER BY
				NAMA_KANTOR";

		$resultSetMapping = new ResultSetMapping();
		$resultSetMapping->addEntityResult($this->_class->getName(), 'k')
			->addFieldResult('k', 'kode', 'kode')
			->addFieldResult('k', 'nama', 'nama');
		
		return $this->_em->createNativeQuery($queryString, $resultSetMapping)
			->getResult();
	}
	
	/**
	 * List seluruh kantor wilayah
	 */
	public function findUnitKerjaWilayah() {
		$queryString = "
			SELECT
				{$this->_class->getColumnName('kode')} AS \"kode\",
				{$this->_class->getColumnName('nama')} AS \"nama\"
			FROM
				{$this->_class->getTableName()}
			WHERE
				KODE_KANTOR_INDUK IN (
					'1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11'
				)
			AND SUBSTR(KODE_KANTOR, 0, 1) = '9'
			AND UPPER(SUBSTR(NAMA_KANTOR, 0, 14)) = 'KANTOR WILAYAH'
			ORDER BY
				NAMA_KANTOR";
	
		$resultSetMapping = new ResultSetMapping();
		$resultSetMapping->addEntityResult($this->_class->getName(), 'k')
			->addFieldResult('k', 'kode', 'kode')
			->addFieldResult('k', 'nama', 'nama');
		
		return $this->_em->createNativeQuery($queryString, $resultSetMapping)
			->getResult();
	}
	
	/**
	 * List seluruh kantor cabang yang terdaftar dalam database.
	 */
	public function findUnitKerjaCabang() {
		$queryString = "
			SELECT
				{$this->_class->getColumnName('kode')} AS \"kode\",
				{$this->_class->getColumnName('nama')} AS \"nama\"
			FROM
				{$this->_class->getTableName()}
			WHERE
				KODE_KANTOR_INDUK IN (
					SELECT
						CASE WHEN SUBSTR(SUBSTR (KODE_KANTOR, 2, 4), 0, 1) = '0' THEN REPLACE(SUBSTR(KODE_KANTOR, 2, 4), '0', '') ELSE SUBSTR(KODE_KANTOR, 2, 4) END
					FROM
						{$this->_class->getTableName()}
					WHERE
						KODE_KANTOR_INDUK IN (
							'1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11'
						)
						AND SUBSTR(KODE_KANTOR, 0, 1) = '9'
						AND UPPER(SUBSTR(NAMA_KANTOR, 0, 14)) = 'KANTOR WILAYAH'
				)
				AND SUBSTR(KODE_KANTOR, 0, 1) <> '9'
				AND UPPER(SUBSTR(NAMA_KANTOR, 0, 14)) <> 'KANTOR WILAYAH'
				AND UPPER(SUBSTR(NAMA_KANTOR, 0, 8)) <> 'CADANGAN'
			ORDER BY
				NAMA_KANTOR";

		$resultSetMapping = new ResultSetMapping();
		$resultSetMapping->addEntityResult($this->_class->getName(), 'k')
			->addFieldResult('k', 'kode', 'kode')
			->addFieldResult('k', 'nama', 'nama');
		
		return $this->_em->createNativeQuery($queryString, $resultSetMapping)
			->getResult();
	}
	
	/**
	 * Retrieve list kantor cabang berdasarkan kantor wilayah.
	 * 
	 * @param Kantor|string $kantorWilayah
	 * @throws \InvalidArgumentException
	 */
	public function findUnitKerjaCabangByWilayah($kantorWilayah) {
		$kodeKantorWilayah = null;
		if($kantorWilayah instanceof Kantor) {
			$kodeKantorWilayah = $kantorWilayah->getKode();
		}
		if(is_string($kantorWilayah)) {
			$kodeKantorWilayah = $kantorWilayah;
		}
		else {
			throw new \InvalidArgumentException(sprintf('Parameter kantor wilayah harus berupa object dari kelas Application\Entity\Kantor atau string kode kantor wilayah'), 100, null);
		}
		
		if(!$this->_em->find($this->_class->getName(), $kodeKantorWilayah)) {
 			throw new \InvalidArgumentException(sprintf('Data kantor dengan kode %s tidak ditemukan dalam database', $kodeKantorWilayah), 100, null);
		}
		
		$queryString = "
			SELECT
				{$this->_class->getColumnName('kode')} AS \"kode\",
				{$this->_class->getColumnName('nama')} AS \"nama\"
			FROM
				{$this->_class->getTableName()}
			WHERE
				KODE_KANTOR_INDUK IN (
					SELECT
						CASE WHEN SUBSTR(SUBSTR (KODE_KANTOR, 2, 4), 0, 1) = '0' THEN REPLACE(SUBSTR(KODE_KANTOR, 2, 4), '0', '') ELSE SUBSTR(KODE_KANTOR, 2, 4) END
					FROM
						{$this->_class->getTableName()}
					WHERE
						KODE_KANTOR_INDUK IN (
							'1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11'
						)
						AND SUBSTR(KODE_KANTOR, 0, 1) = '9'
						AND UPPER(SUBSTR(NAMA_KANTOR, 0, 14)) = 'KANTOR WILAYAH'
				)
				AND SUBSTR(KODE_KANTOR, 0, 1) <> '9'
				AND UPPER(SUBSTR(NAMA_KANTOR, 0, 14)) <> 'KANTOR WILAYAH'
				AND UPPER(SUBSTR(NAMA_KANTOR, 0, 8)) <> 'CADANGAN'
				AND KODE_KANTOR_INDUK = CASE WHEN SUBSTR(SUBSTR('{$kodeKantorWilayah}', 2, 4), 0, 1) = '0' THEN REPLACE(SUBSTR('{$kodeKantorWilayah}', 2, 4), '0', '') ELSE SUBSTR ('{$kodeKantorWilayah}', 2, 4) END
				AND SUBSTR('{$kodeKantorWilayah}', 0, 1) = '9'
			ORDER BY
				NAMA_KANTOR";
		
		$resultSetMapping = new ResultSetMapping();
		$resultSetMapping->addEntityResult($this->_class->getName(), 'k')
			->addFieldResult('k', 'kode', 'kode')
			->addFieldResult('k', 'nama', 'nama');
		
		return $this->_em->createNativeQuery($queryString, $resultSetMapping)
			->getResult();
	}
}