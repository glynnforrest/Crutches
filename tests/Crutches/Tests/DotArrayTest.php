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
		'one' => 'one',
		'two' => array(
			'one' => 'two.one',
			'two' => 'two.two'
		));

	public function testConstruct() {
		$d = new DotArray();
		$this->assertTrue($d instanceof DotArray);
		$e = new DotArray($this->arr);
		$this->assertTrue($e instanceof DotArray);
	}

	public function testGet() {
		$c = new DotArray($this->arr);
		$this->assertEquals('one', $c->get('one'));
		$this->assertEquals('two.one', $c->get('two.one'));
	}

	public function testGetDefault() {
		$c = new DotArray($this->arr);
		$this->assertEquals('default', $c->get('fake-key', 'default'));
		$this->assertEquals('two.one', $c->get('two.one', 'default'));
	}

	public function testGetFirst() {
		$c = new DotArray($this->arr);
		$this->assertEquals('two.one', $c->getFirst('two'));
		$this->assertEquals('one', $c->getFirst());
	}

	public function testGetFirstDefault() {
		$c = new DotArray($this->arr);
		$this->assertEquals('default', $c->getFirst('fake-key', 'default'));
		$this->assertEquals('two.one', $c->getFirst('two', 'default'));
	}

	public function testSet() {
		$c = new DotArray($this->arr);
		$c->set('three', 3);
		$this->assertEquals(3, $c->get('three'));
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
		$this->assertEquals($this->arr, $c->get());
		$this->assertEquals($this->arr, $c->get(null));
	}

	public function testEmptyGetWithDefault() {
		$c = new DotArray($this->arr);
		$this->assertEquals($this->arr, $c->get(null, 'default'));
	}

	public function testMerge() {
		$d = new DotArray($this->arr);
		$override = array(
			'three' => 'three',
			'two' => array(
				'two' => 'changed'
			));
		$expected = array(
			'one' => 'one',
			'two' => array(
				'one' => 'two.one',
				'two' => 'changed'
			),
			'three' => 'three',
		);
		$d->merge($override);
		$this->assertSame($expected, $d->get());
	}

}
