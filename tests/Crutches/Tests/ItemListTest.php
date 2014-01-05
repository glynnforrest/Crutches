<?php

namespace Crutches\Tests;

use Crutches\ItemList;

include(__DIR__ . '/../../bootstrap.php');

/**
 * ItemListTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class ItemListTest extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$l1 = new ItemList();
		$this->assertInstanceOf('Crutches\ItemList', $l1);
		$l2= new ItemList(array());
		$this->assertInstanceOf('Crutches\ItemList', $l2);
	}

	public function testCreate() {
		$l1 = ItemList::create();
		$this->assertInstanceOf('Crutches\ItemList', $l1);
		$l2= ItemList::create(array());
		$this->assertInstanceOf('Crutches\ItemList', $l2);
	}

	public function testGetList() {
		$l = new ItemList(array('one', 'two'));
		$this->assertSame(array('one', 'two'), $l->getList());
	}

	public function testPrefix() {
		$l = new ItemList(array('one', 'two', 'three'));
		$this->assertInstanceOf('\Crutches\ItemList', $l->prefix('$'));
		$this->assertSame(array('$one', '$two', '$three'), $l->getList());
	}

	public function testSuffix() {
		$l = new ItemList(array('one', 'two', 'three'));
		$this->assertInstanceOf('\Crutches\ItemList', $l->suffix('$'));
		$this->assertSame(array('one$', 'two$', 'three$'), $l->getList());
	}

	public function testSurround() {
		$l = new ItemList(array('one', 'two', 'three'));
		$this->assertInstanceOf('\Crutches\ItemList', $l->surround('$'));
		$this->assertSame(array('$one$', '$two$', '$three$'), $l->getList());
	}

	public function stringifyProvider() {
		return array(
			array('foo, bar, baz'),
			array('foo:bar:baz', ':'),
			array(':foo-:bar-:baz', '-', ':'),
			array('`foo`:`bar`:`baz`', ':', '`', '`'),
			array('foo!, bar!, baz!', ', ', '', '!'),
		);
	}

	/**
	 * @dataProvider stringifyProvider()
	 */
	public function testStringify($expected, $delimeter = ', ', $prefix = '', $suffix = '') {
		$l = new ItemList(array('foo', 'bar', 'baz'));
		$string = $l->stringify($delimeter, $prefix, $suffix);
		$this->assertInternalType('string', $string);
		$this->assertSame($expected, $string);
	}

	public function testStringifyEmptyList() {
		$l = new ItemList();
		$string = $l->stringify();
		$this->assertNull($string);
	}

	public function testToStringCallsStringify() {
		$l = new ItemList(array('one'));
		$this->assertSame($l->__toString(), $l->stringify());
	}

	public function testHuman() {
		$l = new ItemList(array('red', 'blue', 'green'));
		$string = $l->human();
		$this->assertInternalType('string', $string);
		$expected = 'The blanket was red, blue and green.';
		$this->assertSame($expected, sprintf("The blanket was %s.", $string));
	}

	public function testHumanDifferentEnding() {
		$l = new ItemList(array('one', 'two', 'three'));
		$string = $l->human(', or');
		$this->assertInternalType('string', $string);
		$expected = 'Pick a number: one, two, or three.';
		$this->assertSame($expected, sprintf("Pick a number: %s.", $string));
	}

	public function testHumanEmptyList() {
		$l = new ItemList();
		$this->assertNull($l->human());
		$this->assertNull($l->human(', or'));
	}

	public function testGet() {
		$l = new ItemList(array('zero', 'one', 'two', 'three'));
		$this->assertSame('zero', $l->get(0));
		$this->assertSame('three', $l->get(3));
		$this->assertNull($l->get(5));
	}

	public function testGetThrowsException() {
		$l = new ItemList(array('zero', 'one', 'two', 'three'));
		$this->setExpectedException('\Exception', 'Argument passed to ItemList::get() is not an integer.');
		$l->get('foo');
	}

	public function testMap() {
		$l = new ItemList(array('foo', 'bar'));
		$f = function($value) {
			return ucfirst($value);
		};
		$this->assertInstanceOf('\Crutches\ItemList', $l->map($f));
		$this->assertSame('Foo', $l->get(0));
	}

	public function testMapThrowsException() {
		$l = new ItemList(array('foo', 'bar'));
		$this->setExpectedException('\Exception', 'Argument passed to ItemList::map() is not callable.');
		$l->map('not a function');
	}

}
