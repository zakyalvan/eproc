<?php
namespace Workflow\Execution\Router;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Workflow\Execution\Router\Exception\RouterException;
use Workflow\Entity\Token;
use Doctrine\ORM\EntityManager;
use Workflow\Entity\Arc;
use Workflow\Entity\Transition;
use Workflow\Entity\Place;

/**
 * Router untuk process.
 * Object dari kelas ini seharusnya dibikin instance-nya dalam ServiceManager.
 * 
 * @author zakyalvan
 */
class ProcessRouter implements ServiceLocatorAware {
	/**
	 * @var ServiceLocator
	 */
	private $serviceLocator;
	
	/**
	 * @var EntityManager
	 */
	private $entityManager;
	
	/**
	 * Route sebuah token dari satu place ke place berikutnya.
	 * 
	 * @param Token $token
	 * @return RouteResult
	 */
	public function routeToNextPlace(Token $token) {
		if($token == null || $token->getId() == null) {
			throw new RouterException("Invalid parameter, token tidak boleh null atau token yang diberikan harus dipersist (id != null).", 100, null);
		}
		
		if($this->entityManager == null) {
			$this->entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		}
		
		try {
			// Ambil dulu input place, dimana token berada.
			$inputPlace = $this->entityManager
				->createQuery('SELECT t.place FROM Workflow\Entity\Token AS t INNER JOIN t.place WHERE t.id=:tokenId')
				->setParameter('tokenId', $token->getId())
				->getSingleResult();
	
			if($inputPlace->getType() == Place::TYPE_END_PLACE) {
				return new RouteResult(false, "Token sudah berada pada end place", RouteResult::TOKEN_ON_END_PLACE_CODE, $inputPlace, $token);
			}
			
			$inputArc = null;
			
			// Hitung input arc dari input place.
			$inputArcsCount = $this->entityManager
				->createQuery("SELECT COUNT(arc) FROM Workflow\Entity\Arc AS arc JOIN arc.place WITH arc.place.id = :placeId WHERE arc.direction = :arcDirection")
				->setParameter('placeId', $inputPlace->getId())
				->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
				->getSingleResult();
			
			// Jika ada lebih dari satu arc yang keluar dari current place.
			if($inputArcsCount > 1) {
				$splitEvaluator = $this->serviceLocator->get($inputPlace->getSplitEvaluator());
				$splitEvaluator->setDatas(array());
				$evaluateResult = $splitEvaluator->evaluate();
				
				// Ambil arc dengan arc.label sesuai dengan hasil evaluator di atas dan yang keluar dari place di atas.
				$inputArc = $this->entityManager
					->createQuery("SELECT arc, arc.transition FROM Workflow\Entity\Arc AS arc JOIN arc.transition JOIN arc.place AS place WITH place.id = :placeId WHERE arc.direction = :arcDirection AND arc.label = :arcLabel")
					->setParameter('placeId', $tokenPlace->getId())
					->setParameter("arcDirection", Arc::ARC_DIRECTION_INPUT)
					->setParameter('arcLabel', $evaluateResult)
					->getSingleResult();
			}
			else if($inputArcsCount == 1) {
				// Ambil arc yang keluar dari token/current place.
				$inputArc = $this->entityManager
					->createQuery('SELECT arc, arc.transition FROM Workflow\Entity\Arc AS arc INNER JOIN arc.transition INNER JOIN arc.place AS place WITH arc.place.id = :placeId WHERE arc.direction = :arcDirection')
					->setParameter('placeId', $tokenPlace->getId())
					->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
					->getSingleResult();
			}
		
			// Ambil transisi.
			$transition = $inputArc->getTransition();
			
			// Eksekusi transition handler pada transisi.
			$transitionHandler = $this->serviceLocator->get($transition->getHandlerName());
			$transitionHandler->handle($transition);
			
			if(strtoupper($transition->getType()) == Transition::TRIGGER_BY_USER) {
				// Balikin hasil route.
				return new RouteResult(false, "", RouteResult::WAIT_USER_TRANSITION_CODE, $inputPlace, $token, $transition);
			}
			else {
				// Ambil output arcs dari transition.
				$outputArcs = $this->entityManager
					->createQuery('SELECT arc, arc.place FROM Workflow\Entity\Arc AS arc JOIN arc.place JOIN arc.transition WITH arc.transition.id = :transitionId WHERE arc.direction = :arcDirection')
					->setParameter('transitionId', $nextTransition->getId)
					->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
					->getResult();
				
				$this->entityManager->beginTransaction();
				
				// Consume token sebelumnya, sebelum buat token pada place berikutnya.
				$token->setStatus(Token::STATUS_CONSUMED);
				/**
				 * TODO Set consumed date.
				 */
				$this->entityManager->persist($token);
				
				// Create token pade masing-masin output place.
				foreach ($outputArcs as $outputArc) {
					$outputPlace = $outputArc->getPlace();
				
					$newToken = new Token();
					$newToken->setPlace($token->getPlace());
					$newToken->setInstance($token->getInstance());
					$newToken->setStatus(Token::STATUS_FREE);

					$this->entityManager->persist($newToken);
				}
				$this->entityManager->commit();
				
				// Eksekusi seluruh perintah persist dan update
				$this->entityManager->flush();
				
				// Balikin hasil route.
				return new RouteResult(true, null, -1, $inputPlace, $token);
			}
		}
		catch(\Exception $e) {
			$this->entityManager->rollback();
			throw new RouterException("Process route gagal.", 200, $e);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
	 */
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}