<?php

namespace Crutches\Tests;

use Crutches\MutableItemList;

/**
 * MutableItemListTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class MutableItemListTest extends ItemListTestCase
{

    protected function newInstance(array $items = array())
    {
        return new MutableItemList($items);
    }

    public function testCreate()
    {
        $this->assertInstanceOf('Crutches\ItemList', MutableItemList::create());
        $this->assertInstanceOf('Crutches\ItemList', MutableItemList::create(array()));
        $this->assertInstanceOf('Crutches\ItemList', MutableItemList::create(array('foo', 'bar')));
    }

    public function testOffsetSet()
    {
        $l = new MutableItemList(array('foo', 'bar'));
        $l[2] = 'baz';
        $this->assertSame(array('foo', 'bar', 'baz'), $l->getList());
    }

    public function testOffsetSetThrowsException()
    {
        $l = new MutableItemList(array('foo', 'bar'));
        $this->setExpectedException('\Exception');
        $l['foo'] = 'baz';
    }

    public function testOffsetUnset()
    {
        $l = new MutableItemList(array('foo', 'bar'));
        unset($l[1]);
        $this->assertSame(array('foo'), $l->getList());
    }

    public function testOffsetUnsetThrowsException()
    {
        $l = new MutableItemList(array('foo', 'bar'));
        $this->setExpectedException('\Exception');
        unset($l['foo']);
    }

}
