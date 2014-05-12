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
			throw new \InvalidArgumentException(
				'Argument passed to ItemList::get() is not an integer.'
			);
		}
		return isset($this->list[$index]) ? $this->list[$index] : null;
	}

    /**
     * Add $string to the start of each value in the list.
     *
     * @param string $string The string to add
     * @param bool $in_place Whether to replace the current list
     */
    public function prefix($string, $in_place = false) {
        $prefixed = array_map(function($value) use ($string) {
            return $string . $value;
        }, $this->list);

        if ($in_place) {
            $this->list = $prefixed;
            return $this;
        }

        return new ItemList($prefixed);
    }

    /**
     * Add $string to the end of each value in the list.
     *
     * @param string $string The string to add
     * @param bool $in_place Whether to replace the current list
     */
    public function suffix($string, $in_place = false) {
        $suffixed = array_map(function($value) use ($string) {
            return $value . $string;
        }, $this->list);

        if ($in_place) {
            $this->list = $suffixed;
            return $this;
        }

        return new ItemList($suffixed);
    }

	/**
	 * Surround each value in the list with a string. $string will be
	 * added to the start and end of each item in the list.
	 *
	 * @param string $string The string to add
     * @param bool $in_place Whether to replace the current list
	 */
	public function surround($string, $in_place = false) {
        $surround = array_map(function($value) use ($string) {
			return $string . $value . $string;
        }, $this->list);

        if ($in_place) {
            $this->list = $surround;
            return $this;
        }

		return new ItemList($surround);
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
	 * @param callable $callback The function to map over each item
     * @param bool $in_place Whether to replace the current list
	 */
	public function map($callback, $in_place = false) {
		if(!is_callable($callback)) {
			throw new \InvalidArgumentException(
				'Argument passed to ItemList::map() is not callable.'
			);
		}

        $mapped = array_map($callback, $this->list);

        if ($in_place) {
            $this->list = $mapped;
            return $this;
        }

		return new ItemList($mapped);
	}

	/**
	 * Use $callback to filter items in this list. Array keys are
	 * reset after filtering.
	 *
	 * @param callable $callback The function to filter the list.
     * @param bool $in_place Whether to replace the current list
	 */
	public function filter($callback, $in_place = false) {
		if(!is_callable($callback)) {
			throw new \InvalidArgumentException(
				'Argument passed to ItemList::filter() is not callable.'
			);
		}
        $filtered = array_values(array_filter($this->list, $callback));

        if ($in_place) {
            $this->list = $filtered;
            return $this;
        }

		return new ItemList($filtered);
	}

    /**
     * Take a number of elements from the start of this ItemList.
     *
     * If amount is negative, elements will be taken up until that
     * many elements from the end of the array.
     *
     * @param int $amount The amount of elements to take
     * @param bool $in_place Replace the current list if true, return a new instance if false
     * @return ItemList An ItemList instance with the selected elements
     */
    public function take($amount, $in_place = false)
    {
        if (!is_int($amount)) {
            throw new \InvalidArgumentException('ItemList#take() expects an integer argument');
        }

        $taken = array_slice($this->list, 0, $amount);

        if ($in_place) {
            $this->list = $taken;
            return $this;
        }

        return new ItemList($taken);
    }

    /**
     * Take a number of random elements from this ItemList.
     *
     * @param int $amount The amount of elements to take
     * @param bool $in_place Replace the current list if true, return a new instance if false
     * @return ItemList An ItemList instance with the selected elements
     */
    public function takeRandom($amount, $in_place = false)
    {
        if (!is_int($amount)) {
            throw new \InvalidArgumentException('ItemList#take() expects an integer argument');
        }

        $keys = (array) array_rand($this->list, $amount);

        $taken = array_map(function($key) {
            return $this->list[$key];
        }, $keys);

        if ($in_place) {
            $this->list = $taken;
            return $this;
        }

        return new ItemList($taken);
    }

    /**
     * Shuffle the list.
     *
     * @param bool $in_place Replace the current list if true, return a new instance if false
     */
    public function shuffle($in_place = false)
    {
        if ($in_place) {
            shuffle($this->list);
            return $this;
        }

        $shuffled = $this->list;
        shuffle($shuffled);

        return new ItemList($shuffled);
    }

}