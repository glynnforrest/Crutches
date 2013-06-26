<?php

namespace Crutches\Tests\Inflector;

use Crutches\Inflector\EN;

include(__DIR__ . '/../../../bootstrap.php');

/**
 * ENTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class ENTest extends \PHPUnit_Framework_TestCase {

	public function testPlural() {
		$inf = new EN();
		$this->assertEquals('cats', $inf->plural('cats'));
		$this->assertEquals('cats', $inf->plural('cat'));
		$this->assertEquals('mice', $inf->plural('mouse'));
		$this->assertEquals('lice', $inf->plural('louse'));
		$this->assertEquals('houses', $inf->plural('house'));
		$this->assertEquals('buses', $inf->plural('bus'));
		$this->assertEquals('sheep', $inf->plural('sheep'));
		$this->assertEquals('cacti', $inf->plural('cactus'));
		$this->assertEquals('octopi', $inf->plural('octopus'));
		$this->assertEquals('fish', $inf->plural('fish'));
		$this->assertEquals('wishes', $inf->plural('wish'));
		$this->assertEquals('boxes', $inf->plural('box'));
		$this->assertEquals('witches', $inf->plural('witch'));
		$this->assertEquals('jeans', $inf->plural('jeans'));
		$this->assertEquals('scissors', $inf->plural('scissors'));
		$this->assertEquals('curries', $inf->plural('curry'));
		$this->assertEquals('flies', $inf->plural('fly'));
		$this->assertEquals('pringles', $inf->plural('pringle'));
		$this->assertEquals('tomatoes', $inf->plural('tomato'));
		$this->assertEquals('monkeys', $inf->plural('monkey'));
		$this->assertEquals('shoes', $inf->plural('shoe'));
		$this->assertEquals('messages', $inf->plural('message'));
		$this->assertEquals('geese', $inf->plural('goose'));
	}

	public function testSingle() {
		$inf = new EN();
		$this->assertEquals('cat', $inf->single('cat'));
		$this->assertEquals('cat', $inf->single('cats'));
		$this->assertEquals('mouse', $inf->single('mice'));
		$this->assertEquals('louse', $inf->single('lice'));
		$this->assertEquals('house', $inf->single('houses'));
		$this->assertEquals('bus', $inf->single('buses'));
		$this->assertEquals('sheep', $inf->single('sheep'));
		$this->assertEquals('cactus', $inf->single('cacti'));
		$this->assertEquals('octopus', $inf->single('octopi'));
		$this->assertEquals('fish', $inf->single('fish'));
		$this->assertEquals('wish', $inf->single('wishes'));
		$this->assertEquals('box', $inf->single('boxes'));
		$this->assertEquals('witch', $inf->single('witches'));
		$this->assertEquals('jeans', $inf->single('jeans'));
		$this->assertEquals('scissors', $inf->single('scissors'));
		$this->assertEquals('curry', $inf->single('curries'));
		$this->assertEquals('fly', $inf->single('flies'));
		$this->assertEquals('pringle', $inf->single('pringles'));
		$this->assertEquals('tomato', $inf->single('tomatoes'));
		$this->assertEquals('monkey', $inf->single('monkeys'));
		$this->assertEquals('shoe', $inf->single('shoes'));
		$this->assertEquals('message', $inf->single('messages'));
		$this->assertEquals('goose', $inf->single('geese'));
	}

}
