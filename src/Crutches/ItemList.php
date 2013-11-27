<?php

namespace Crutches;

/**
 * ItemList
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class ItemList {

	protected $list;

	/**
	 * Create a new ItemList with $list.
	 *
	 * @param array $list An array of items.
	 */
	public function __construct(array $list = array()) {
		$this->list = $list;
	}

	/**
	 * Create a new ItemList with $list.
	 *
	 * @param array $list An array of items.
	 */
	public static function create(array $list = array()) {
		return new self($list);
	}


	/**
	 * Return the list of items in this ItemList.
	 */
	public function getList() {
		return $this->list;
	}

	/**
	 * Add $string to the start of each value in the list.
	 *
	 * @param string $string The string to add
	 */
	public function prefix($string) {
		foreach ($this->list as &$value) {
			$value = $string . $value;
		}
		return $this;
	}

	/**
	 * Add $string to the end of each value in the list.
	 *
	 * @param string $string The string to add
	 */
	public function suffix($string) {
		foreach ($this->list as &$value) {
			$value = $value . $string;
		}
		return $this;
	}

	/**
	 * Surround each value in the list with a string. $string will be
	 * added to the start and end of each item in the list.
	 *
	 * @param string $string The string to add
	 */
	public function surround($string) {
		return $this->prefix($string)->suffix($string);
	}

	/**
	 * Convert this ItemList to a string, seperating each value
	 * with $delimeter. If supplied, $prefix and $suffix will be added
	 * to each value. Unlike prefix(), suffix(), and surround(), the
	 * list is not modified.
	 *
	 * @param string $delimeter The string to separate the value with
	 * @param string $prefix The string to add to the start of each value
	 * @param string $suffix The string to add to the end of each value
	 */
	public function stringify($delimeter = ', ', $prefix = '', $suffix = '') {
		$string = '';
		foreach($this->list as $value) {
			$string .= $prefix . $value . $suffix . $delimeter;
		}
		return rtrim($string, $delimeter);
	}

	public function __toString() {
		return $this->stringify();
	}

}
