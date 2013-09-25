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
	 * Code jika routing gagal karena transisi yang dilewati harus ditrigger oleh user.
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
	
	private $success = false;
	private $message;
	private $code;
	
	/**
	 * @var Place
	 */
	private $from;
	
	/**
	 * @var Token
	 */
	private $fromToken;
	
	/**
	 * @var Transition
	 */
	private $transition;
	
	/**
	 * @var Place
	 */
	private $next;
	
	/**
	 * @var Token
	 */
	private $nextToken;
	
	/**
	 * Konstruktor
	 * 
	 * @param unknown $success
	 * @param unknown $message
	 * @param unknown $code
	 * @param Place $from
	 * @param Token $fromToken
	 * @param Transition $transition Transisi yang dilewati.
	 * @param Place $next
	 * @param Token $nextToken
	 */
	public function __construct($success, $message, $code, Place $from, Token $fromToken, Transition $transition = null, Place $next = null, Token $nextToken = null) {
		$this->success = $success;
		$this->message = $message;
		$this->code = $code;
		$this->from = $from;
		$this->fromToken = $fromToken;
		$this->next = $next;
		$this->nextToken = $nextToken;
	}
	
	public function isSuccess() {
		return $this->success;
	}
	public function getMessage() {
		return $this->message;
	}
	/**
	 * Retrieve code jika routing ada error, jika tidak ada error balikin -1.
	 */
	public function getCode() {
		return $this->code;
	}
	public function getFrom() {
		return $this->from;
	}
	public function getFromToken() {
		return $this->fromToken;
	}
	public function getNext() {
		return $this->next;
	}
	public function getNextToken() {
		return $this->nextToken;
	}
}