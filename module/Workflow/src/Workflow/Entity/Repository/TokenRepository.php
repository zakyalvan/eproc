<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Instance;
use Doctrine\ORM\Query\Expr\Join;
use Workflow\Entity\Place;
use Workflow\Entity\Token;

/**
 * Custom token repository.
 * 
 * @author zakyalvan
 */
class TokenRepository extends EntityRepository {
	/**
	 * Apakah ada free token untuk instance dan pada place yang diberikan.
	 * 
	 * @param unknown $instance
	 * @param unknown $place
	 */
	public function hasFreeToken($instance, $place) {
		if($this->countFreeToken($instance, $place) > 0) {
			return true;
		}
		return false;
	}
	
	/**
	 * Count free tokens pada place yang sebelumnya.
	 * 
	 * @param unknown $instance
	 * @param unknown $place
	 */
	public function countFreeToken($instance, $place) {
		$instanceId = null;
		if($instance instanceof Instance) {
			$instanceId = $instance->getId();
		}
		else if(is_numeric($instance)) {
			$instanceId = $instance;
		}
		else {
			throw new \InvalidArgumentException('Parameter instance harus berupa instance dari kelas Workflow\Entity\Instance atau integer kode instance', 100, null);
		}
		
		$placeId = null;
		if($place instanceof Place) {
			$placeId = $place->getId();
		}
		else if(is_numeric($place)) {
			$placeId = $place;
		}
		else {
			throw new \InvalidArgumentException('Parameter place harus berupa instance dari kelas Workflow\Entity\Place atau integer kode place', 100, null);
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		return $queryBuilder->select($queryBuilder->expr()->count('token'))
			->from('Workflow\Entity\Token', 'token')
			->innerJoin('token.instance', 'instance', Join::WITH, $queryBuilder->expr()->eq('instance.id', ':instanceId'))
			->innerJoin('token.place', 'place', Join::WITH, $queryBuilder->expr()->eq('place.id', ':placeId'))
			->where($queryBuilder->expr()->eq('token.status', Token::STATUS_FREE))
			->setParameter('instanceId', $instanceId)
			->setParameter('placeId', $placeId)
			->getQuery()
			->getSingleResult();
	}
	
	/**
	 * Retrieve free token pada place dan instance yang diberikan.
	 * 
	 * @param unknown $instance
	 * @param unknown $place
	 * @throws \InvalidArgumentException
	 * @return Ambigous <\Doctrine\ORM\mixed, mixed, multitype:, \Doctrine\DBAL\Driver\Statement, \Doctrine\Common\Cache\mixed>
	 */
	public function getFreeToken($instance, $place) {
		$instanceId = $instance;
		if($instance instanceof Instance) {
			$instanceId = $instance->getId();
		}
		else {
			throw new \InvalidArgumentException('Parameter instance harus berupa instance dari kelas Workflow\Entity\Instance atau integer kode instance', 100, null);
		}
		
		$placeId = $place;
		if($place instanceof Place) {
			$placeId = $place->getId();
		}
		else {
			throw new \InvalidArgumentException('Parameter place harus berupa instance dari kelas Workflow\Entity\Place atau integer kode place', 100, null);
		}
		
		$queryBuilder = $this->_em->createQueryBuilder();
		$freeToken = $queryBuilder->select('token')
			->from('Workflow\Entity\Token', 'token')
			->innerJoin('token.instance', 'instance', Join::WITH, $queryBuilder->expr()->eq('instance.id', ':instanceId'))
			->innerJoin('token.place', 'place', Join::WITH, $queryBuilder->expr()->eq('place.id', ':placeId'))
			->where($queryBuilder->expr()->eq('token.status', Token::STATUS_FREE))
			->setParameter('instanceId', $instanceId)
			->setParameter('placeId', $placeId)
			->getQuery()
			->getOneOrNullResult();
		
		if($freeToken) {
			throw new \InvalidArgumentException('Tidak ada free token pada place yang instance yang diberikan', 100, null);
		}
	}
}