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
	 * Get the element $index in this ItemList, or null if not defined.
	 *
	 * @param int $index The index of the element.
	 */
	public function get($index) {
		if(!is_int($index)) {
			throw new \Exception(
				'Argument passed to ItemList::get() is not an integer.'
			);
		}
		return isset($this->list[$index]) ? $this->list[$index] : null;
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
		foreach ($this->list as &$value) {
			$value = $string . $value . $string;
		}
		return $this;
	}

	/**
	 * Get this ItemList as a string, separating each value with
	 * $delimeter. If supplied, $prefix and $suffix will be added to
	 * each value. The list is not modified.
	 *
	 * @param string $delimeter The string to separate the value with
	 * @param string $prefix The string to add to the start of each value
	 * @param string $suffix The string to add to the end of each value
	 */
	public function stringify($delimeter = ', ', $prefix = '', $suffix = '') {
		if(empty($this->list)) {
			return null;
		}
		$string = '';
		foreach($this->list as $value) {
			$string .= $prefix . $value . $suffix . $delimeter;
		}
		return rtrim($string, $delimeter);
	}

	public function __toString() {
		return $this->stringify();
	}

	/**
	 * Get this ItemList as a string, where each value is separated
	 * with a comma and space, except for the last item, which will be
	 * prefixed with $ending (default is ' and'). The list is not
	 * modified.
	 *
	 * @param string $ending The string to use before the last item
	 */
	public function human($ending = ' and') {
		if(empty($this->list)) {
			return null;
		}
		$string = '';
		foreach($this->list as $value) {
			$string .= $value . ', ';
		}
		$string = rtrim($string, ', ');
		$second_last_comma = strrpos($string, ', ');
		return substr($string, 0, $second_last_comma) . $ending . ' ' . end($this->list);
	}

	/**
	 * Map $callback over all items in this list.
	 *
	 * @param callable $callback The function to map over each item in
	 * this list.
	 */
	public function map($callback) {
		if(!is_callable($callback)) {
			throw new \Exception(
				'Argument passed to ItemList::map() is not callable.'
			);
		}
		$this->list = array_map($callback, $this->list);
		return $this;
	}

}
