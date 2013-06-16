<?php

namespace Crutches\Tests;

use Crutches\DotArray;

include(__DIR__ . '/../../bootstrap.php');

/**
 * DotArrayTest
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class DotArrayTest extends \PHPUnit_Framework_TestCase {

    protected $arr1 = array(
			'one' => 1,
			'two' => array(
				'one' => 2.1,
				'two' => 2.2
			));

    public function testConstruct() {
        $d = new DotArray();
        $this->assertTrue($d instanceof DotArray);
        $e = new DotArray($this->arr1);
        $this->assertTrue($e instanceof DotArray);
    }



}
