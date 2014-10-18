<?php

namespace Crutches\Tests;

use Crutches\MutableItemList;

/**
 * ItemListTestCase
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
abstract class ItemListTestCase extends \PHPUnit_Framework_TestCase
{
    abstract protected function newInstance(array $items = array());

    public function testGetList()
    {
        $l = $this->newInstance(array('one', 'two'));
        $this->assertSame(array('one', 'two'), $l->getList());
    }

    public function testKeysAreRemovedOnCreation()
    {
        $l = $this->newInstance(array('one', 'foo' => 'bar', 'baz', 5 => 'five'));
        $this->assertSame(array('one', 'bar', 'baz', 'five'), $l->getList());
    }

    public function testImplementsArrayAccess()
    {
        $this->assertInstanceOf('\ArrayAccess', $this->newInstance(array()));
    }

    public function testOffsetGet()
    {
        $l = $this->newInstance(array('one', 'two'));
        $this->assertSame('one', $l[0]);
        $this->assertNull($l[3]);
    }

    public function testOffsetGetThrowsException()
    {
        $l = $this->newInstance(array());
        $this->setExpectedException('\Exception');
        $var = $l['foo'];
    }

    public function testOffsetExists()
    {
        $l = $this->newInstance(array('one', 'two'));
        $this->assertTrue(isset($l[0]));
        $this->assertTrue(isset($l[1]));
        $this->assertFalse(isset($l[2]));
    }

    public function testCountable()
    {
        $l = $this->newInstance(array('one', 'two', 'three'));
        $this->assertInstanceOf('\Countable', $l);
        $this->assertSame(3, count($l));

        $modified = $l->set(3, 'four');
        $this->assertSame(4, count($modified));
    }

    public function testPrefix()
    {
        $l = $this->newInstance(array('one', 'two', 'three'));
        $prefixed = $l->prefix('$');
        $this->assertSame(array('$one', '$two', '$three'), $prefixed->getList());
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $prefixed);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $prefixed);
            $this->assertNotSame($l, $prefixed);
        }
    }

    public function testPrefixInPlace()
    {
        $l = $this->newInstance(array('one', 'two', 'three'));
        $prefixed = $l->prefix('$', true);
        $this->assertSame($l, $prefixed);
        $this->assertSame(array('$one', '$two', '$three'), $prefixed->getList());
    }

    public function testSuffix()
    {
        $l = $this->newInstance(array('one', 'two', 'three'));
        $suffixed = $l->suffix('$');
        $this->assertSame(array('one$', 'two$', 'three$'), $suffixed->getList());
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $suffixed);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $suffixed);
            $this->assertNotSame($l, $suffixed);
        }
    }

    public function testSuffixInPlace()
    {
        $l = $this->newInstance(array('one', 'two', 'three'));
        $suffixed = $l->suffix('$', true);
        $this->assertSame($l, $suffixed);
        $this->assertSame(array('one$', 'two$', 'three$'), $suffixed->getList());
    }

    public function testSurround()
    {
        $l = $this->newInstance(array('one', 'two', 'three'));
        $surrounded = $l->surround('$');
        $this->assertSame(array('$one$', '$two$', '$three$'), $surrounded->getList());
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $surrounded);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $surrounded);
            $this->assertNotSame($l, $surrounded);
        }
    }

    public function testSurroundInPlace()
    {
        $l = $this->newInstance(array('one', 'two', 'three'));
        $surrounded = $l->surround('$', true);
        $this->assertSame($l, $surrounded);
        $this->assertSame(array('$one$', '$two$', '$three$'), $surrounded->getList());
    }

    public function stringifyProvider()
    {
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
    public function testStringify($expected, $delimeter = ', ', $prefix = '', $suffix = '')
    {
        $l = $this->newInstance(array('foo', 'bar', 'baz'));
        $string = $l->stringify($delimeter, $prefix, $suffix);
        $this->assertSame($expected, $string);
    }

    public function testStringifyEmptyList()
    {
        $l = $this->newInstance();
        $string = $l->stringify();
        $this->assertSame('', $string);
    }

    public function testToStringCallsStringify()
    {
        $l = $this->newInstance(array('one'));
        $this->assertSame($l->__toString(), $l->stringify());
    }

    public function testHuman()
    {
        $l = $this->newInstance(array('red', 'blue', 'green'));
        $string = $l->human();
        $this->assertInternalType('string', $string);
        $expected = 'The blanket was red, blue and green.';
        $this->assertSame($expected, sprintf("The blanket was %s.", $string));
    }

    public function testHumanDifferentEnding()
    {
        $l = $this->newInstance(array('one', 'two', 'three'));
        $string = $l->human(', or');
        $this->assertInternalType('string', $string);
        $expected = 'Pick a number: one, two, or three.';
        $this->assertSame($expected, sprintf("Pick a number: %s.", $string));
    }

    public function testHumanEmptyList()
    {
        $l = $this->newInstance();
        $this->assertSame('', $l->human());
        $this->assertSame('', $l->human(', or'));
    }

    public function testGet()
    {
        $l = $this->newInstance(array('zero', 'one', 'two', 'three'));
        $this->assertSame('zero', $l->get(0));
        $this->assertSame('three', $l->get(3));
        $this->assertNull($l->get(5));
    }

    public function testGetThrowsException()
    {
        $l = $this->newInstance(array('zero', 'one', 'two', 'three'));
        $this->setExpectedException('\InvalidArgumentException', 'Index passed to ItemList::get() is not an integer.');
        $l->get('foo');
    }

    public function testSet()
    {
        $l = $this->newInstance(array('foo', 'bar', 'baz'));
        $modified = $l->set(3, 'quo');
        $this->assertSame(array('foo', 'bar', 'baz', 'quo'), $modified->getList());
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $modified);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $modified);
            $this->assertNotSame($l, $modified);
        }
    }

    public function testSetInPlace()
    {
        $l = $this->newInstance(array('foo', 'bar', 'baz'));
        $modified = $l->set(3, 'quo', true);
        $this->assertSame(array('foo', 'bar', 'baz', 'quo'), $modified->getList());
        $this->assertSame($l, $modified);
    }

    public function testSetThrowsException()
    {
        $l = $this->newInstance(array());
        $this->setExpectedException('\InvalidArgumentException', 'Index passed to ItemList::set() is not an integer.');
        $l->set('foo', 'bar');
    }

    public function testRemove()
    {
        $l = $this->newInstance(array('foo', 'bar', 'baz'));
        $modified = $l->remove(2);
        $this->assertSame(array('foo', 'bar'), $modified->getList());
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $modified);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $modified);
            $this->assertNotSame($l, $modified);
        }
    }

    public function testRemoveInPlace()
    {
        $l = $this->newInstance(array('foo', 'bar', 'baz'));
        $modified = $l->remove(2, true);
        $this->assertSame(array('foo', 'bar'), $modified->getList());
        $this->assertSame($l, $modified);
    }

    public function testRemoveThrowsException()
    {
        $l = $this->newInstance(array());
        $this->setExpectedException('\InvalidArgumentException', 'Index passed to ItemList::remove() is not an integer.');
        $l->remove('foo');
    }

    public function testMap()
    {
        $l = $this->newInstance(array('foo', 'bar'));
        $f = function ($value) {
            return ucfirst($value);
        };
        $mapped = $l->map($f);
        $this->assertSame('Foo', $mapped->get(0));
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $mapped);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $mapped);
            $this->assertNotSame($l, $mapped);
        }
    }

    public function testMapInPlace()
    {
        $l = $this->newInstance(array('foo', 'bar'));
        $mapped = $l->map('strtoupper', true);
        $this->assertInstanceOf('Crutches\ItemList', $mapped);
        $this->assertSame($l, $mapped);
        $this->assertSame('FOO', $mapped->get(0));
    }

    public function testMapThrowsException()
    {
        $l = $this->newInstance(array('foo', 'bar'));
        $this->setExpectedException('\InvalidArgumentException', 'Argument passed to ItemList::map() is not callable.');
        $l->map('not a function');
    }

    public function testFilter()
    {
        $l = $this->newInstance(array(0, 1, 2, 3, 4));
        $f = function ($value) {
            return $value % 2 == 0;
        };
        $filtered = $l->filter($f);
        $this->assertSame(array(0, 2, 4), $filtered->getList());
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $filtered);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $filtered);
            $this->assertNotSame($l, $filtered);
        }
    }

    public function testFilterInPlace()
    {
        $l = $this->newInstance(array(0, 1, 2, 3, 4));
        $filtered = $l->filter(function ($value) {
            return $value % 2 == 0;
        }, true);
        $this->assertSame($l, $filtered);
        $this->assertSame(array(0, 2, 4), $filtered->getList());
    }

    public function testFilterThrowsException()
    {
        $l = $this->newInstance(array('foo', 'bar'));
        $this->setExpectedException('\InvalidArgumentException', 'Argument passed to ItemList::filter() is not callable.');
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
        $l = $this->newInstance($original_list);
        $taken = $l->take($amount);
        $this->assertSame($new_list, $taken->getList());
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $taken);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $taken);
            $this->assertNotSame($l, $taken);
        }
    }

    /**
     * @dataProvider takeProvider()
     */
    public function testTakeInPlace($original_list, $amount, $new_list)
    {
        $l = $this->newInstance($original_list);
        $taken = $l->take($amount, true);
        $this->assertSame($l, $taken);
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
    public function testTakeThrowsException($argument)
    {
        $l = $this->newInstance(array('foo', 'bar'));
        $this->setExpectedException('\InvalidArgumentException');
        $l->take($argument);
    }

    public function dropProvider()
    {
        return array(
            array(array('foo', 'bar', 'baz'), 1, array('bar', 'baz')),
            array(array('foo', 'bar', 'baz'), 2, array('baz')),
            array(array('foo'), 2, array()),
            array(array('foo', 'bar'), 0, array('foo', 'bar'))
        );
    }

    /**
     * @dataProvider dropProvider()
     */
    public function testDrop($original_list, $amount, $new_list)
    {
        $l = $this->newInstance($original_list);
        $remaining = $l->drop($amount);
        $this->assertSame($new_list, $remaining->getList());
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $remaining);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $remaining);
            $this->assertNotSame($l, $remaining);
        }
    }

    /**
     * @dataProvider dropProvider()
     */
    public function testDropInPlace($original_list, $amount, $new_list)
    {
        $l = $this->newInstance($original_list);
        $remaining = $l->drop($amount, true);
        $this->assertSame($l, $remaining);
        $this->assertSame($new_list, $remaining->getList());
    }

    public function invalidDropProvider()
    {
        return array(
            array(true),
            array(false),
            array(new \stdClass()),
            array(array()),
            array('foo'),
            array(-1)
        );
    }

    /**
     * @dataProvider invalidDropProvider()
     */
    public function testDropThrowsException($argument)
    {
        $l = $this->newInstance(array('foo', 'bar'));
        $this->setExpectedException('\InvalidArgumentException');
        $l->drop($argument);
    }

    public function testShuffle()
    {
        $l = $this->newInstance(array('foo', 'bar', 'baz', 'quo'));
        $shuffled = $l->shuffle();
        $this->assertTrue(count($shuffled->getList()) === 4);

        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $shuffled);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $shuffled);
            $this->assertNotSame($l, $shuffled);
            // check the original has not been modified
            $this->assertSame(array('foo', 'bar', 'baz', 'quo'), $l->getList());
        }
    }

    public function testShuffleInPlace()
    {
        $l = $this->newInstance(array('foo', 'bar', 'baz', 'quo'));
        $shuffled = $l->shuffle(true);
        $this->assertSame($l, $shuffled);
        $this->assertTrue(count($shuffled->getList()) === 4);
    }

    public function testTakeRandom()
    {
        $l = $this->newInstance(array('foo', 'bar', 'baz', 'quo'));
        $taken = $l->takeRandom(1);
        $this->assertTrue(count($taken->getList()) === 1);
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $taken);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $taken);
            $this->assertNotSame($l, $taken);
        }
    }

    public function testTakeRandomInPlace()
    {
        $l = $this->newInstance(array('foo', 'bar', 'baz', 'quo'));
        $taken = $l->takeRandom(2, true);
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
        $l = $this->newInstance($original_list);
        $sliced = $l->slice($offset, $length);
        $this->assertSame($new_list, $sliced->getList());
        if ($l instanceof MutableItemList) {
            $this->assertSame($l, $sliced);
        } else {
            $this->assertInstanceOf('Crutches\ItemList', $sliced);
            $this->assertNotSame($l, $sliced);
        }
    }

    /**
     * @dataProvider sliceProvider()
     */
    public function testSliceInPlace($original_list, $offset, $length, $new_list)
    {
        $l = $this->newInstance($original_list);
        $sliced = $l->slice($offset, $length, true);
        $this->assertSame($l, $sliced);
        $this->assertSame($new_list, $sliced->getList());
    }

}
