<?php

namespace Crutches\Tests;

use Crutches\DotArray;

include(__DIR__ . '/../../bootstrap.php');

/**
 * DotArrayTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class DotArrayTest extends \PHPUnit_Framework_TestCase {

	protected $arr = array(
		'one' => 1,
		'two' => array(
			'one' => 2.1,
			'two' => 2.2
		));

	public function testConstruct() {
		$d = new DotArray();
		$this->assertTrue($d instanceof DotArray);
		$e = new DotArray($this->arr);
		$this->assertTrue($e instanceof DotArray);
	}

	public function testGet() {
		$c = new DotArray($this->arr);
		$this->assertEquals(1, $c->get('one'));
		$this->assertEquals(2.1, $c->get('two.one'));
		$expected = array(
			'one' => 1,
			'two' => array(
				'one' => 2.1,
				'two' => 2.2
			)
		);
		$this->assertEquals($expected, $c->get());
	}

	public function testGetDefault() {
		$c = new DotArray($this->arr);
		$this->assertEquals('default', $c->get('fake-key', 'default'));
		$expected = array(
			'one' => 1,
			'two' => array(
				'one' => 2.1,
				'two' => 2.2
			)
		);
		$this->assertEquals($expected, $c->get(null, 'default'));
	}

	public function testGetFirst() {
		$c = new DotArray($this->arr);
		$this->assertEquals(2.1, $c->getFirst('two'));
		$this->assertEquals(1, $c->getFirst());
	}

	public function testGetFirstDefault() {
		$c = new DotArray($this->arr);
		$this->assertEquals('default', $c->getFirst('fake-key', 'default'));
	}

	public function testSet() {
		$c = new DotArray($this->arr);
		$c->set('three', 3);
		$this->assertEquals(3, $c->get('three'));
	}

	public function testSetNoFile() {
		$c = new DotArray($this->arr);
		$c->set('ad-hoc', 'data');
		$this->assertEquals('data', $c->get('ad-hoc'));
		$c->set('nested', array('value' => 'foo'));
		$this->assertEquals('foo', $c->get('nested.value'));
	}

	public function testSetNested() {
		$c = new DotArray();
		$c->set('parent.child', 'value');
		$this->assertEquals(array('parent' => array('child' => 'value')), $c->get());
	}

	public function testGetNested() {
		$c = new DotArray($this->arr);
		$c->set('parent', array('child' => 'value'));
		$this->assertEquals('value', $c->get('parent.child'));
	}

	public function testSetDeepNested() {
		$c = new DotArray();
		$c->set('parent.child.0.1.2.3.4', 'value');
		$this->assertEquals(array('parent' => array('child' => array(
			0 => array(1 => array(2 => array(3 => array(4 =>'value'))))))), $c->get());
	}

	public function testGetDeepNested() {
		$c = new DotArray($this->arr);
		$c->set('parent', array('child' => array(
			0 => array(1 => array(2 => array(3 => array(4 =>'value')))))));
		$this->assertEquals('value', $c->get('parent.child.0.1.2.3.4'));
	}

	public function testEmptyGet() {
		$c = new DotArray($this->arr);
		$this->assertEquals(array(
			'one' => 1,
			'two' => array(
				'one' => 2.1,
				'two' => 2.2
			)
		), $c->get());
		$this->assertEquals(array(
			'one' => 1,
			'two' => array(
				'one' => 2.1,
				'two' => 2.2
			)
		), $c->get(null));
	}

}
