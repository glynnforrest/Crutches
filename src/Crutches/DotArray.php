<?php

namespace Crutches;

/**
 * DotArray provides an interface to an array using the
 * 'dot array syntax', i.e
 *
 * $arr->get('parent.child.child') => $arr['parent']['child']['child']
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class DotArray
{
    protected $array = array();

    public function __construct(array $array = array())
    {
        $this->array = $array;
    }

    /**
     * Get a value from the array that matches $key. $key uses the dot
     * array syntax, e.g. parent.child.child. If the key matches an
     * array the whole array will be returned. If no key is specified
     * the entire array will be returned. $default will be returned
     * (null unless specified) if the key is not found.
     *
     * @param  string $key     The key
     * @param  mixed  $default The default value to return
     * @return mixed  The value
     */
    public function get($key = null, $default = null)
    {
        if ($key === null) {
            return $this->array;
        }
        $parts = explode('.', $key);
        $scope = &$this->array;
        for ($i = 0; $i < count($parts) - 1; $i++) {
            if (!isset($scope[$parts[$i]])) {
                return $default;
            }
            $scope = &$scope[$parts[$i]];
        }
        if (isset($scope[$parts[$i]])) {
            return $scope[$parts[$i]];
        }

        return $default;
    }

    /**
     * Get the first value from an array of values that matches $key.
     * $default will be returned (null unless specified) if the key is
     * not found or does not contain an array.
     *
     * @param  string $key     The key
     * @param  mixed  $default The default value to return
     * @return mixed  The value
     */
    public function getFirst($key = null, $default = null)
    {
        $array = self::get($key);
        if (!is_array($array)) {
            return $default;
        }
        reset($array);

        return current($array);
    }

    /**
     * Set an array value with $key. $key uses the dot array syntax,
     * e.g. parent.child.child. If $value is an array this will also
     * be accessible using the dot array syntax.
     *
     * @param string $key     The key
     * @param mixed  $default The default value to return
     */
    public function set($key, $value)
    {
        $parts = explode('.', $key);
        //loop through each part, create it if not present.
        $scope = &$this->array;
        $count = count($parts) - 1;
        for ($i = 0; $i < $count; $i++) {
            if (!isset($scope[$parts[$i]])) {
                $scope[$parts[$i]] = array();
            }
            $scope = &$scope[$parts[$i]];
        }
        $scope[$parts[$i]] = $value;
    }

    /**
     * Merge values with values from $array. Any conflicting keys will
     * be overwritten by those in $array.
     *
     * @param array $array The array to merge
     */
    public function merge(array $array)
    {
        $this->array = array_replace_recursive($this->array, $array);
    }

}
