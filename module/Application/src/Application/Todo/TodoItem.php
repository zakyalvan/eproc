<?php
namespace Application\Todo;

/**
 * Kontrak untuk todo item.
 * 
 * @author zakyalvan
 */
interface TodoItem {
	/**
	 * Context dari todo.
	 */
	public function getContext();
	/**
	 * Kapan todo ini dibuat.
	 */
	public function getCreatedDate();
	/**
	 * Action url untuk eksekusi todo item bersangkutan.
	 */
	public function getActionUrl();
	/**
	 * Ambil data dari todo.
	 * 
	 * @param unknown $name
	 */
	public function getData($name);
}