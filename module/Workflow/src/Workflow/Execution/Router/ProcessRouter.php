<?php
namespace Workflow\Execution\Router;

use Zend\ServiceManager\ServiceLocatorAwareInterface as ServiceLocatorAware;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
use Doctrine\ORM\EntityManager;
use Workflow\Execution\Router\Exception\RouterException;
use Workflow\Entity\Token;
use Workflow\Entity\Arc;
use Workflow\Entity\Transition;
use Workflow\Entity\Place;
use Workflow\Execution\Router\Exception\ProcessRouterException;

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
			throw new ProcessRouterException("Invalid parameter, token tidak boleh null atau token yang diberikan harus dipersist (id != null).", 100, null);
		}
		
		try {
			// Ambil instance untuk token yang diberikan.
			$instance = $this->entityManager
				->createQuery('SELECT token.instance FROM Workflow\Entity\Token AS token INNER JOIN token.instance WHERE token.id = :tokenId')
				->setParameter('tokenId', $token->getId())
				->getSingleResult();
			
			// Ambil dulu input place, dimana token berada.
			$inputPlace = $this->entityManager
				->createQuery('SELECT token.place FROM Workflow\Entity\Token AS token INNER JOIN token.place WHERE token.id=:tokenId')
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
				->getScalarResult();
			
			// Jika ada lebih dari satu arc yang keluar dari input place.
			if($inputArcsCount > 1) {
				$splitEvaluator = $this->serviceLocator->get($inputPlace->getSplitEvaluator());
				
				$this->entityManager->getRepository('Workflow\Entity\Instance')->getDatasAsArray($instance);
				$splitEvaluator->setDatas(array());
				$evaluationResult = $splitEvaluator->evaluate();
				
				// Ambil arc dengan arc.label sesuai dengan hasil evaluator di atas dan yang keluar dari place di atas.
				$inputArc = $this->entityManager
					->createQuery("SELECT arc, arc.transition FROM Workflow\Entity\Arc arc JOIN arc.transition JOIN arc.place AS place WITH place.id = :placeId WHERE arc.direction = :arcDirection AND arc.label = :arcLabel")
					->setParameter('placeId', $tokenPlace->getId())
					->setParameter("arcDirection", Arc::ARC_DIRECTION_INPUT)
					->setParameter('arcLabel', $evaluationResult)
					->getSingleResult();
			}
			// Jika hanya ada satu arc yang keluar dari input place.
			else if($inputArcsCount == 1) {
				// Ambil arc yang keluar dari token/current place.
				$inputArc = $this->entityManager
					->createQuery('SELECT arc, arc.transition FROM Workflow\Entity\Arc arc INNER JOIN arc.transition INNER JOIN arc.place AS place WITH arc.place.id = :placeId WHERE arc.direction = :arcDirection')
					->setParameter('placeId', $tokenPlace->getId())
					->setParameter('arcDirection', Arc::ARC_DIRECTION_INPUT)
					->getSingleResult();
			}
			else {
				throw new ProcessRouterException("Jumlah arc yang keluar dari input place (place-id : {$inputPlace->getId()}) = 0.", 100, null);
			}
		
			// Ambil transisi.
			$transition = $inputArc->getTransition();
			
			// Eksekusi transition handler pada transisi.
			$transitionHandler = $this->serviceLocator->get($transition->getHandlerName());
			$transitionHandler->handle($transition, $instance);
			
			if(strtoupper($transition->getType()) == Transition::TRIGGER_BY_USER) {
				// Balikin hasil route.
				return new RouteResult(false, "Menunggu transisi ditrigger oleh user", RouteResult::WAIT_USER_TRANSITION_CODE, $inputPlace, $token, $transition);
			}
			else if(strtoupper($transition->getType()) == Transition::TRIGGER_BY_AUTO) {
				// Ambil output arcs dari transition.
				$outputArcs = $this->entityManager
					->createQuery('SELECT arc, arc.place FROM Workflow\Entity\Arc arc JOIN arc.place JOIN arc.transition WITH arc.transition.id = :transitionId WHERE arc.direction = :arcDirection')
					->setParameter('transitionId', $nextTransition->getId)
					->setParameter('arcDirection', Arc::ARC_DIRECTION_OUTPUT)
					->getResult();
				
				// Consume free token sebelumnya, kemudian buat free token baru pada place berikutnya.
				$token->setStatus(Token::STATUS_CONSUMED);
				/**
				 * TODO Set consumed date.
				 */
				$this->entityManager->persist($token);
				
				// Ini untuk kebutuhan routing-result.
				$nextPlaces = array();
				$nextTokens = array();
				
				foreach ($outputArcs as $outputArc) {
					$outputPlace = $outputArc->getPlace();
					$nextPlaces[] = $outputPlace;
				
					$newToken = new Token();
					$newToken->setPlace($token->getPlace());
					$newToken->setInstance($token->getInstance());
					$newToken->setStatus(Token::STATUS_FREE);

					$this->entityManager->persist($newToken);
					
					$nextTokens[] = $newToken;
				}
				
				// Balikin route result.
				return new RouteResult(true, null, -1, $inputPlace, $token, $transition, $nextPlaces, $nextTokens);
			}
			else {
				throw new RouterException('Belum bisa routing melalui transition dengan type transisi MESG dan TIME');
			}
		}
		catch(\Exception $e) {
			$result = new RouteResult(false, 'Exception terjadi', RouteResult::EXCEPTION_ON_ROUTING_CODE, $inputPlace, $token);
			$result->setException($e);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocator $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
		
		if($this->entityManager == null) {
			$this->entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
	 */
	public function getServiceLocator() {
		return $this->serviceLocator;
	}
}