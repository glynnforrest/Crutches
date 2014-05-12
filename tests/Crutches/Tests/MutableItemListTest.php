<?php

namespace Crutches\Tests;

require_once __DIR__ . '/../../bootstrap.php';

use Crutches\MutableItemList;

/**
 * MutableItemListTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class MutableItemListTest extends \PHPUnit_Framework_TestCase
{

    public function testPrefix()
    {
        $l = new MutableItemList(array('one', 'two', 'three'));
        $prefixed = $l->prefix('$');
        $this->assertSame($l, $prefixed);
        $this->assertSame(array('$one', '$two', '$three'), $prefixed->getList());
    }

    public function testSuffix()
    {
        $l = new MutableItemList(array('one', 'two', 'three'));
        $suffixed = $l->suffix('$');
        $this->assertSame($l, $suffixed);
        $this->assertSame(array('one$', 'two$', 'three$'), $suffixed->getList());
    }

    public function testSurround()
    {
        $l = new MutableItemList(array('one', 'two', 'three'));
        $surrounded = $l->surround('$');
        $this->assertSame($l, $surrounded);
        $this->assertSame(array('$one$', '$two$', '$three$'), $surrounded->getList());
    }

    public function testMap()
    {
        $l = new MutableItemList(array('foo', 'bar'));
        $walked = $l->map('strtoupper');
        $this->assertInstanceOf('Crutches\ItemList', $walked);
        $this->assertSame($l, $walked);
        $this->assertSame('FOO', $walked->get(0));
    }

    public function testFilter()
    {
        $l = new MutableItemList(array(0, 1, 2, 3, 4));
        $filtered = $l->filter(function($value) {
            return $value % 2 == 0;
        });
        $this->assertSame($l, $filtered);
        $this->assertSame(array(0, 2, 4), $filtered->getList());
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
        $l = new MutableItemList($original_list);
        $taken = $l->take($amount);
        $this->assertSame($l, $taken);
        $this->assertSame($new_list, $taken->getList());
    }

    public function testShuffle()
    {
        $l = new MutableItemList(array('foo', 'bar', 'baz', 'quo'));
        srand(0);
        $shuffled = $l->shuffle();
        $this->assertSame($l, $shuffled);
        $this->assertSame(array('baz', 'foo', 'quo', 'bar'), $shuffled->getList());
    }

    public function testTakeRandom()
    {
        $l = new MutableItemList(array('foo', 'bar', 'baz', 'quo'));
        srand(0);
        $taken = $l->takeRandom(1);
        $this->assertSame($l, $taken);
        $this->assertSame(array('baz'), $taken->getList());
    }

}
