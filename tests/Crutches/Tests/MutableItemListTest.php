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

}
