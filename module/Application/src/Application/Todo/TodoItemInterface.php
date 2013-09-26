<?php
namespace Application\Todo;

/**
 * Kontrak untuk todo item.
 * 
 * @author zakyalvan
 */
interface TodoItemInterface {
	/**
	 * Context dari todo.
	 */
	public function getContext();
	/**
	 * Ambil data dari todo.
	 *
	 * @param unknown $name
	 */
	public function getData($name);
	/**
	 * Action url untuk eksekusi todo item bersangkutan.
	 */
	public function getActionUrl();
	/**
	 * Kapan todo ini dibuat.
	 */
	public function getCreatedDate();
}