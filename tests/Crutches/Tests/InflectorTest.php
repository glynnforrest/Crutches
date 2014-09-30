<?php

namespace Crutches\Tests;

use Crutches\Inflector;

/**
 * InflectorTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class InflectorTest extends \PHPUnit_Framework_TestCase {

	public function testLocale() {
		$this->assertInstanceOf('\Crutches\Inflector\EN', Inflector::locale());
		$this->assertInstanceOf('\Crutches\Inflector\EN', Inflector::locale('EN'));
	}

	public function testLocaleThrowsExceptionInvalidLocale() {
		$msg = 'Unable to load Inflector class \Crutches\Inflector\Pirate';
		$this->setExpectedException('\Exception', $msg);
		Inflector::locale('Pirate');
	}

}
