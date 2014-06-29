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
        $shuffled = $l->shuffle();
        $this->assertSame($l, $shuffled);
        $this->assertTrue(count($shuffled->getList()) === 4);
    }

    public function testTakeRandom()
    {
        $l = new MutableItemList(array('foo', 'bar', 'baz', 'quo'));
        $taken = $l->takeRandom(2);
        $this->assertSame($l, $taken);
        $this->assertTrue(count($taken->getList()) === 2);
    }

    public function sliceProvider()
    {
        return array(
            array(array('foo', 'bar', 'baz'), 1, 2, array('bar', 'baz')),
            array(array('foo'), 2, 2, array()),
            array(array('foo', 'bar'), 3, 0, array()),
            array(array('foo', 'bar', 'baz'), -1, 1, array('baz')),
            array(array('foo', 'bar', 'baz'), -4, 4, array('foo', 'bar', 'baz'))
        );
    }

    /**
     * @dataProvider sliceProvider()
     */
    public function testSlice($original_list, $offset, $length, $new_list)
    {
        $l = new MutableItemList($original_list);
        $sliced = $l->slice($offset, $length);
        $this->assertSame($l, $sliced);
        $this->assertSame($new_list, $sliced->getList());
    }

}
