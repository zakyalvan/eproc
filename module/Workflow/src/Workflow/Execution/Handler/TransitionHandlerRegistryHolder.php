<?php
namespace Workflow\Execution\Handler;

/**
 * Kontrak untuk object yang nyimpan transition handler registry.
 * 
 * @author zakyalvan
 */
interface TransitionHandlerRegistryHolder {
	/**
	 * @return TransitionHandlerRegistryHolder
	 */
	public function getRegistry();
}