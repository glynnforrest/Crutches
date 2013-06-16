<?php

namespace Crutches;

/**
 * DotArray
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class DotArray {

    protected $array = array();

    public function __construct(array $array = array()) {
            $this->array = $array;
    }

}
