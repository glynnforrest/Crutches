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
        $mapped = $l->map($f);
		$this->assertInstanceOf('\Crutches\ItemList', $mapped);
        $this->assertNotSame($l, $mapped);
		$this->assertSame('Foo', $mapped->get(0));
	}

	public function testMapThrowsException() {
		$l = new ItemList(array('foo', 'bar'));
		$this->setExpectedException('\Exception', 'Argument passed to ItemList::map() is not callable.');
		$l->map('not a function');
	}

	public function testFilter() {
		$l = new ItemList(array(0, 1, 2, 3, 4));
		$f = function($value) {
			return $value % 2 == 0;
		};
        $filtered = $l->filter($f);
		$this->assertInstanceOf('\Crutches\ItemList', $filtered);
        $this->assertNotSame($l, $filtered);
		$this->assertSame(array(0, 2, 4), $filtered->getList());
	}

	public function testFilterThrowsException() {
		$l = new ItemList(array('foo', 'bar'));
		$this->setExpectedException('\Exception', 'Argument passed to ItemList::filter() is not callable.');
		$l->filter('not a function');
	}

    public function takeProvider()
    {
        return array(
            array(array('foo', 'bar', 'baz'), 2, array('foo', 'bar')),
            array(array('foo'), 2, array('foo')),
            array(array('foo', 'bar'), 0, array()),
            //negative numbers count from the right
            array(array('foo', 'bar', 'baz'), -1, array('foo', 'bar')),
            array(array('foo', 'bar', 'baz'), -4, array())
        );
    }

    /**
     * @dataProvider takeProvider()
     */
    public function testTake($original_list, $amount, $new_list)
    {
        $l = new ItemList($original_list);
        $taken = $l->take($amount);
        $this->assertInstanceOf('Crutches\ItemList', $taken);
        $this->assertSame($new_list, $taken->getList());
    }

    public function invalidTakeProvider()
    {
        return array(
            array(true),
            array(false),
            array(new \stdClass()),
            array(array()),
            array('foo')
        );
    }

    /**
     * @dataProvider invalidTakeProvider()
     */
    public function testTakeThrowsException()
    {
        $l = new ItemList(array('foo', 'bar'));
        $this->setExpectedException('\InvalidArgumentException');
        $l->take(true);
    }

}
