<?php
namespace Application\Common;

/**
 * Kontrak unutuk key generator.
 * 
 * @author zakyalvan
 */
interface KeyGeneratorInterface {
	/**
	 * Generate next key value.
	 * 
	 * @param unknown $context
	 * @param unknown $key
	 */
	public function generateNextKey($context, $keyName);
}