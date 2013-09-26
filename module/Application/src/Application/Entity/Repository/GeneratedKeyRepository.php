<?php
namespace Application\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\GeneratedKey;

/**
 * Custom repository untuk key generated entity.
 * 
 * @author zakyalvan
 */
class GeneratedKeyRepository extends EntityRepository {
	/**
	 * Generate next key.
	 * By convension, selain di service object, tidak ada flush entity manager.
	 * 
	 * @param unknown $context
	 * @param unknown $keyName
	 * @return Ambigous <number, unknown>
	 */
	public function generateNextKey($context, $keyName) {
		$maxGenerated = $this->_em->createQuery('SELECT MAX(key.generated) FROM Application\Entity\GeneatedKey key WHERE key.context = :keyContext AND key.key = :keyName')
			->setParameter('keyContext', $context)
			->setParameter('keyName', $keyName)
			->getSingleScalarResult();
		
		$newKey = 1;
		if($maxGenerated) {
			$newKey += $maxGenerated;
		}
		
		$newGeneratedKey = new GeneratedKey($context, $keyName, $newKey);
		$this->_em->persist($newGeneratedKey);
		
		return $newKey;
	}
}