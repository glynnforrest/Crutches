<?php

namespace Crutches\Tests\Inflector;

use Crutches\Inflector\EN;

/**
 * ENTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class ENTest extends \PHPUnit_Framework_TestCase {

	public function pluralsProvider() {
		return array(
			array('cat', 'cats'),
			array('mouse', 'mice'),
			array('louse', 'lice'),
			array('house', 'houses'),
			array('bus', 'buses'),
			array('sheep', 'sheep'),
			array('cactus', 'cacti'),
			array('octopus', 'octopi'),
			array('fish', 'fish'),
			array('wish', 'wishes'),
			array('box', 'boxes'),
			array('witch', 'witches'),
			array('jeans', 'jeans'),
			array('scissors', 'scissors'),
			array('curry', 'curries'),
			array('fly', 'flies'),
			array('pringle', 'pringles'),
			array('tomato', 'tomatoes'),
			array('monkey', 'monkeys'),
			array('shoe', 'shoes'),
			array('message', 'messages'),
			array('goose', 'geese'),
			array('moose', 'moose'),
			array('deer', 'deer'),
		);
	}

	/**
	 * @dataProvider pluralsProvider()
	 */
	public function testPlural($singular, $plural) {
		$inf = new EN();
		$this->assertSame($plural, $inf->plural($singular));
	}

	/**
	 * @dataProvider pluralsProvider()
	 */
	public function testSingle($singular, $plural) {
		$inf = new EN();
		$this->assertSame($singular, $inf->single($plural));
	}

}
