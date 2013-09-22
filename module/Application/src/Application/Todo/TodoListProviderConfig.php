<?php
namespace Application\Todo;

use Application\Todo\Exception\RuntimeException;
/**
 * Konfigurasi untuk todo list provider. Sebenarnya nyimpan nama kelas provider untuk todo list.
 * 
 * @author zakyalvan
 */
class TodoListProviderConfig {
	private static $defaultProfiders = array();
	
	public static function addDefaultProvider($provider) {
		if(!(is_string($provider) && class_exists($provider))) {
			throw new RuntimeException("Class todo list provider yang diberikan {$provider} tidak ditemukan.", 100, null);
		}
		self::$defaultProfiders[$provider] = $provider;
	}
	
	private $providers = array();
	
	public function __construct() {
		$this->providers = array_merge($this->providers, self::$defaultProfiders);
	}
	
	/**
	 * Add provider baru. Jika class provider yang diberikan tidak ditemukan, throw runtime exception.
	 * 
	 * @param unknown $provider
	 * @throws RuntimeException
	 */
	public function addProvider($provider) {
		if(!class_exists($provider)) {
			throw new RuntimeException("Class todo list provider yang diberikan {$provider} tidak ditemukan.", 100, null);
		}
		$this->providers[$provider] = $provider;
	}
	/**
	 * Apakah provider yang diberikan terdaftar atau tidak.
	 * 
	 * @param unknown $provider
	 * @return boolean
	 */
	public function hasProvider($provider) {
		return array_key_exists($provider, $this->providers);
	}
	
	public function getProvider($provider) {
		return $this->providers[$provider];
	}
	
	/**
	 * Set sejumlah provider. Sementara key dari array providers diabaikan.
	 * 
	 * @param array $providers
	 */
	public function setProviders(array $providers) {
		foreach ($providers as $provider) {
			$this->addProvider($provider);
		}
	}
	/**
	 * Retrieve copy-an dari providers (supaya ga dimanipulasi dari luar).
	 * 
	 * @return multitype:
	 */
	public function getProviders() {
		return array_merge(array(), $this->providers);
	}
}