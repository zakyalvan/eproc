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
		if(is_object($context)) {
			$context = get_class($context);
		}
		else if(is_string($context)) {
			$context = $context;
		}
		else {
			throw new \InvalidArgumentException('Parameter context tidak valid, valid berupa object atau string', 100, null);
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$maxGenerated = $queryBuilder->select($queryBuilder->expr()->max('key.generated'))
			->from('Application\Entity\GeneratedKey', 'key')
			->where($queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('key.context', ':keyContext'),
				$queryBuilder->expr()->eq('key.key', ':keyName')
			))
			->setParameter('keyContext', $context)
			->setParameter('keyName', $keyName)
			->getQuery()
			->getSingleScalarResult();
		
		$newKey = 1;
		if($maxGenerated) {
			$newKey += $maxGenerated;
		}
		
		$newGeneratedKey = new GeneratedKey($context, $keyName, $newKey);
		$this->_em->persist($newGeneratedKey);
		$this->_em->flush($newGeneratedKey);
		
		return $newKey;
	}
}