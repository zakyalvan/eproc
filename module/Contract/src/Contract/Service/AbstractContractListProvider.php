<?php
namespace Contract\Service;

use Application\Common\AbstractListProvider;

/**
 * Abstract kelas untuk contract list privider.
 * Seharusnya kelas ini dibikin instance-nya dalam service locator.
 * Kelas ini spesifik menggunakan doctrine orm, kelas turunanan dari kelas ini hanya perlu mengimplementasi satu method.
 * 
 * @author zakyalvan
 */
abstract class AbstractContractListProvider extends AbstractListProvider implements ContractListProviderInterface {
	const KONTRAK_HARGA_SATUAN_LIST_PROVIDER = 'Contract\Service\HargaSatuanContract';
}