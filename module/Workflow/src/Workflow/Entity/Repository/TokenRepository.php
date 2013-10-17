<?php
namespace Workflow\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Workflow\Entity\Instance;
use Doctrine\ORM\Query\Expr\Join;
use Workflow\Entity\Place;
use Workflow\Entity\Token;
use Doctrine\ORM\UnitOfWork;

/**
 * Custom token repository.
 * 
 * @author zakyalvan
 */
class TokenRepository extends EntityRepository {
	/**
	 * 
	 * @param Instance $instance
	 * @param Place $place
	 * @throws \InvalidArgumentException
	 * @return integer
	 */
	public function countToken(Instance $instance, Place $place) {
		$instance = $this->ensureManagedEntity($instance);
		$place = $this->ensureManagedEntity($place);
		
		if($place->getWorkflow()->getId() !== $instance->getWorkflow()->getId()) {
 			throw new \InvalidArgumentException('Parameter tidak valid. Object place dan instance bukan dari definisi workflow yang sama', 100, null);
 		}
		
		$queryBuilder = $this->getEntityManager()->createQueryBuilder();
		return $queryBuilder->select($queryBuilder->expr()->count('t'))
			->from('Workflow\Entity\Token', 't')
			->innerJoin('t.instance', 'inst', Join::WITH, $queryBuilder->expr()->eq('inst.id', ':instanceId'))
			->innerJoin('inst.workflow', 'instanceWorkflow', Join::WITH, $queryBuilder->expr()->eq('instanceWorkflow.id', ':instanceWorkflowId'))
			->innerJoin('t.place', 'place', Join::WITH, $queryBuilder->expr()->eq('place.id', ':placeId'))
			->innerJoin('place.workflow', 'placeWorkflow', Join::WITH, $queryBuilder->expr()->eq('placeWorkflow.id', ':placeWorkflowId'))
			->setParameter('instanceId', $instance->getId())
			->setParameter('instanceWorkflowId', $instance->getWorkflow()->getId())
			->setParameter('placeId', $place->getId())
			->setParameter('placeWorkflowId', $place->getWorkflow()->getId())
			->getQuery()
			->getSingleScalarResult();
	}
	
	/**
	 * Apakah ada free token untuk instance dan pada place yang diberikan.
	 * 
	 * @param unknown $instance
	 * @param unknown $place
	 */
	public function hasFreeToken($instance, $place) {
		return $this->countFreeToken($instance, $place) > 0 ? true : false;
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
	
	protected function ensureManagedEntity($entity) {
		if($entity == null) {
			throw new \InvalidArgumentException('Parameter entity tidak boleh null', 100, null);
		}
	
		$entityState = $this->getEntityManager()->getUnitOfWork()->getEntityState($entity);
		if(!($entityState == UnitOfWork::STATE_MANAGED || $entityState == UnitOfWork::STATE_DETACHED)) {
			throw new \InvalidArgumentException(sprintf('Parameter entity harus instance dari object entity dengan state manage atau detached'), 100, null);
		}
	
		if($entityState == UnitOfWork::STATE_DETACHED) {
			return $this->getEntityManager()->merge($entity);
		}
		return $entity;
	}
}