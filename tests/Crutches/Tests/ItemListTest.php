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

	public function testToStringCallsStringify() {
		$l = new ItemList(array('one'));
		$this->assertSame($l->__toString(), $l->stringify());
	}


}
