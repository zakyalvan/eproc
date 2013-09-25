<?php
namespace Workflow\Execution\Router;

use Workflow\Entity\Place;
use Workflow\Entity\Token;
use Workflow\Entity\Transition;

/**
 * Routing result.
 * 
 * @author zakyalvan
 */
class RouteResult {
	/**
	 * Code jika routing gagal karena transisi yang dilewati harus menunggu ditrigger oleh user.
	 * 
	 * @var integer
	 */
	const WAIT_USER_TRANSITION_CODE = 111;
	
	/**
	 * Jika routing gagal karena token sudah berada pada end place.
	 * 
	 * @var unknown
	 */
	const TOKEN_ON_END_PLACE_CODE = 112;
	
	/**
	 * Code jika terjadi eksepsi dalam proses routing.
	 * 
	 * @var unknown
	 */
	const EXCEPTION_ON_ROUTING_CODE = 113;
	
	private $success = false;
	private $message;
	private $code;
	
	/**
	 * @var Place
	 */
	private $fromPlace;
	
	/**
	 * @var Token
	 */
	private $fromToken;
	
	/**
	 * Transisi yang dilewati dalam proses routing.
	 * 
	 * @var Transition
	 */
	private $transition;
	
	/**
	 * Place-place terakhir tempat token-token setelah routing berhasil.
	 */
	private $nextPlaces;
	
	/**
	 * Token-token yang digenerate setelah routing berhasil.
	 */
	private $nextTokens;
	
	/**
	 * Exception yang ditangkap pada saat proses routing.
	 * 
	 * @var unknown
	 */
	private $exception;
	
	public function __construct($success, $message, $code, Place $fromPlace, Token $fromToken, Transition $transition = null, $nextPlaces = array(), $nextTokens = array()) {
		$this->success = $success;
		$this->message = $message;
		$this->code = $code;
		$this->fromPlace = $fromPlace;
		$this->fromToken = $fromToken;
		$this->transition = $transition;
		$this->nextPlaces = $nextPlaces;
		$this->nextTokens = $nextTokens;
	}
	
	public function isSuccess() {
		return $this->success;
	}
	public function getMessage() {
		return $this->message;
	}
	/**
	 * Retrieve code jika routing ada error, jika tidak ada error balikin -1.
	 * 
	 * @return integer
	 */
	public function getCode() {
		return $this->code;
	}
	public function getFromPlace() {
		return $this->fromPlace;
	}
	public function getFromToken() {
		return $this->fromToken;
	}
	/**
	 * Retrieve transition yang dilewati dalam proses rousing.
	 * 
	 * @return \Workflow\Entity\Transition
	 */
	public function getTransition() {
		return $this->transition;
	}
	public function getNextPlaces() {
		return $this->nextPlaces;
	}
	public function getNextTokens() {
		return $this->nextTokens;
	}
	
	public function getException() {
		return $this->exception;
	}
	public function setException(Exception $exception) {
		$this->exception = $exception;
	}
}