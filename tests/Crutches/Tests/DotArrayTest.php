<?php

namespace Crutches\Tests;

use Crutches\DotArray;

/**
 * DotArrayTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class DotArrayTest extends \PHPUnit_Framework_TestCase
{
    protected $arr = array(
        'one' => 'one',
        'two' => array(
            'one' => 'two.one',
            'two' => 'two.two'
        ));

    public function testGet()
    {
        $c = new DotArray($this->arr);
        $this->assertSame('one', $c->get('one'));
        $this->assertSame('two.one', $c->get('two.one'));
    }

    public function testGetDefault()
    {
        $c = new DotArray($this->arr);
        $this->assertSame('default', $c->get('fake-key', 'default'));
        $this->assertSame('two.one', $c->get('two.one', 'default'));

        $c->set('foo.bar.baz', 'something');
        $this->assertSame('default', $c->get('foo.bar.fake-key.foo', 'default'));
    }

    public function testGetNumericKeys()
    {
        $c = new DotArray(array('foo', 'bar', array('one', 'two')));
        $this->assertSame('foo', $c->get('0'));
        $this->assertSame('foo', $c->get(0));
        $this->assertSame('bar', $c->get('1'));
        $this->assertSame('bar', $c->get(1));
        $this->assertSame('one', $c->get('2.0'));
        $this->assertSame('two', $c->get('2.1'));
        $this->assertSame('two', $c->get(2.1));
    }

    public function testGetFirst()
    {
        $c = new DotArray($this->arr);
        $this->assertSame('two.one', $c->getFirst('two'));
        $this->assertSame('one', $c->getFirst());
    }

    public function testGetFirstDefault()
    {
        $c = new DotArray($this->arr);
        $this->assertSame('default', $c->getFirst('fake-key', 'default'));
        $this->assertSame('two.one', $c->getFirst('two', 'default'));
    }

    public function testGetFirstNoKey()
    {
        $c = new DotArray($this->arr);
        $c->set('foo', array('foo', 'bar', 'baz'));
        $this->assertSame('foo', $c->getFirst('foo'));
    }

    public function testSet()
    {
        $c = new DotArray($this->arr);
        $c->set('three', 3);
        $this->assertSame(3, $c->get('three'));
    }

    public function testSetNested()
    {
        $c = new DotArray();
        $c->set('parent.child', 'value');
        $this->assertSame(array('parent' => array('child' => 'value')), $c->get());
    }

    public function testGetNested()
    {
        $c = new DotArray($this->arr);
        $c->set('parent', array('child' => 'value'));
        $this->assertSame('value', $c->get('parent.child'));
    }

    public function testSetDeepNested()
    {
        $c = new DotArray();
        $c->set('parent.child.0.1.2.3.4', 'value');
        $this->assertSame(array('parent' => array('child' => array(
            0 => array(1 => array(2 => array(3 => array(4 =>'value'))))))), $c->get());
    }

    public function testGetDeepNested()
    {
        $c = new DotArray($this->arr);
        $c->set('parent', array('child' => array(
            0 => array(1 => array(2 => array(3 => array(4 =>'value')))))));
        $this->assertSame('value', $c->get('parent.child.0.1.2.3.4'));
    }

    public function testEmptyGet()
    {
        $c = new DotArray($this->arr);
        $this->assertSame($this->arr, $c->get());
        $this->assertSame($this->arr, $c->get(null));
    }

    public function testEmptyGetWithDefault()
    {
        $c = new DotArray($this->arr);
        $this->assertSame($this->arr, $c->get(null, 'default'));
    }

    public function testMerge()
    {
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

    public function testRemove()
    {
        $d = new DotArray($this->arr);
        $d->remove('one');
        $expected = array(
            'two' => array(
                'one' => 'two.one',
                'two' => 'two.two',
            ),
        );
        $this->assertSame($expected, $d->get());
    }

    public function testRemoveNested()
    {
        $d = new DotArray($this->arr);
        $d->remove('two.one');
        $expected = array(
            'one' => 'one',
            'two' => array(
                'two' => 'two.two',
            ),
        );
        $this->assertSame($expected, $d->get());
    }

    public function testRemoveDeeplyNested()
    {
        $d = new DotArray($this->arr);
        $d->set('foo.bar.baz', array(
            'one' => 'one',
            'two' => 'two',
        ));
        $d->remove('foo.bar.baz.one');
        $expected = array(
            'one' => 'one',
            'two' => array(
                'one' => 'two.one',
                'two' => 'two.two',
            ),
            'foo' => array(
                'bar' => array(
                    'baz' => array(
                        'two' => 'two',
                    ),
                ),
            ),
        );
        $this->assertSame($expected, $d->get());
    }

    public function testRemoveUnknownKey()
    {
        $d = new DotArray($this->arr);
        $d->remove('foo.bar.baz');
        $this->assertSame($this->arr, $d->get());
    }

    public function testExists()
    {
        $d = new DotArray($this->arr);
        $this->assertTrue($d->exists('one'));
        $this->assertTrue($d->exists('two.two'));
        $this->assertFalse($d->exists('foo.bar'));

        $d->set('two.two', false);
        $this->assertTrue($d->exists('two.two'));

        $d->remove('two.two');
        $this->assertFalse($d->exists('two.two'));

        $d->set('two.two', null);
        $this->assertFalse($d->exists('two.two'));
    }
}
