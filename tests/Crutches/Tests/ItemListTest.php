<?php

namespace Crutches\Tests;

use Crutches\ItemList;

/**
 * ItemListTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class ItemListTest extends ItemListTestCase
{

    protected function newInstance(array $items = array())
    {
        return new ItemList($items);
    }

    public function testCreate()
    {
        $this->assertInstanceOf('Crutches\ItemList', ItemList::create());
        $this->assertInstanceOf('Crutches\ItemList', ItemList::create(array()));
        $this->assertInstanceOf('Crutches\ItemList', ItemList::create(array('foo', 'bar')));
    }

    public function testOffsetSet()
    {
        $l = $this->newInstance(array());
        $this->setExpectedException('\Exception');
        $l[0] = 'foo';
    }

    public function testOffsetUnset()
    {
        $l = $this->newInstance(array('foo'));
        $this->setExpectedException('\Exception');
        unset($l[0]);
    }

}
