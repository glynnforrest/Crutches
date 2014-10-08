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

}
