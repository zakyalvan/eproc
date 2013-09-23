<?php
namespace Application\Common;

/**
 * Kontrak untuk object-object yang membutuhkan identity hasil authentikasi, jika ada.
 * Injeksi automatis dengan syarat, object dari kelas yang meng-implement interface ini
 * di service locator. Initializernya {@link IdentityAwareInitializer}
 * 
 * @author zakyalvan
 */
interface IdentityAwareInterface {
	/**
	 * Inject identity dari user yang sedang login.
	 * 
	 * @param unknown $identity
	 */
	public function injectIdentity($identity);
}