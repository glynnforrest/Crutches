<?php

namespace Crutches;

/**
 * MutableItemList
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class MutableItemList extends ItemList
{

    public function set($index, $value, $in_place = true)
    {
        return parent::set($index, $value, $in_place);
    }

    public function remove($index, $in_place = true)
    {
        return parent::remove($index, $in_place);
    }

    public function prefix($string, $in_place = true)
    {
        return parent::prefix($string, $in_place);
    }

    public function suffix($string, $in_place = true)
    {
        return parent::suffix($string, $in_place);
    }

    public function surround($string, $in_place = true)
    {
        return parent::surround($string, $in_place);
    }

    public function map($callable, $in_place = true)
    {
        return parent::map($callable, $in_place);
    }

    public function filter($callable, $in_place = true)
    {
        return parent::filter($callable, $in_place);
    }

    public function take($amount, $in_place = true)
    {
        return parent::take($amount, $in_place);
    }

    public function takeRandom($amount, $in_place = true)
    {
        return parent::takeRandom($amount, $in_place);
    }

    public function drop($amount, $in_place = true)
    {
        return parent::drop($amount, $in_place);
    }

    public function shuffle($in_place = true)
    {
        return parent::shuffle($in_place);
    }

    public function slice($offset, $length, $in_place = true)
    {
        return parent::slice($offset, $length, $in_place);
    }

    public function offsetSet($offset, $value)
    {
        if (!is_int($offset)) {
            throw new \InvalidArgumentException('MutableItemList#offsetUnset() expects an integer argument');
        }

        $this->list[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if (!is_int($offset)) {
            throw new \InvalidArgumentException('MutableItemList#offsetUnset() expects an integer argument');
        }

        unset($this->list[$offset]);
    }

}
