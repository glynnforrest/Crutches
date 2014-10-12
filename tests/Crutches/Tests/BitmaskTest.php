<?php

namespace Crutches\Tests;

use Crutches\Bitmask;

/**
 * BitmaskTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class BitmaskTest extends \PHPUnit_Framework_TestCase
{
    const ONE = 1;
    const TWO = 2;
    const FOUR = 4;

    public function testGetBitmask()
    {
        $bitmask = new Bitmask(51);
        $this->assertEquals(51, $bitmask->getBitmask());
    }

    public function testSetBitmask()
    {
        $bitmask = new Bitmask();
        $this->assertInstanceOf('\Crutches\Bitmask', $bitmask->setBitmask(31));
        $this->assertEquals(31, $bitmask->getBitmask());
        $bitmask = new Bitmask(4);
        $bitmask->setBitmask(1);
        $this->assertEquals(1, $bitmask->getBitmask());
    }

    public function hasFlagProvider()
    {
        return array(
            array(true, BitmaskTest::ONE),
            array(false, BitmaskTest::TWO),
            array(true, 5),
            array(true, BitmaskTest::ONE | BitmaskTest::FOUR),
            array(false, BitmaskTest::ONE | BitmaskTest::TWO),
            array(false, BitmaskTest::ONE | BitmaskTest::TWO | BitmaskTest::FOUR)
        );
    }

    /**
	 * @dataProvider hasFlagProvider();
	 */
    public function testHasFlag($expected, $test)
    {
        $bitmask = new Bitmask(5);
        $this->assertSame($expected, $bitmask->hasFlag($test));
    }

    public function testAddFlag()
    {
        $bitmask = new Bitmask();
        $this->assertInstanceOf('\Crutches\Bitmask', $bitmask->addFlag(2));
        $this->assertEquals(2, $bitmask->getBitmask());

        //repeat to check the bit isn't flipped
        $bitmask->addFlag(2);
        $this->assertEquals(2, $bitmask->getBitmask());

        $bitmask->addFlag(1);
        $this->assertEquals(3, $bitmask->getBitmask());

        $bitmask->addFlag(8 | 16);
        $this->assertEquals(27, $bitmask->getBitmask());

        $bitmask->addFlag(4 | 1);
        $this->assertEquals(31, $bitmask->getBitmask());
    }

    public function testRemoveFlag()
    {
        $bitmask = new Bitmask(21);

        $this->assertInstanceOf('\Crutches\Bitmask', $bitmask->removeFlag(1));
        $this->assertFalse($bitmask->hasFlag(1));
        $this->assertEquals(20, $bitmask->getBitmask());

        //repeat to check the bit isn't flipped
        $bitmask->removeFlag(1);
        $this->assertEquals(20, $bitmask->getBitmask());
        $this->assertFalse($bitmask->hasFlag(1));

        $bitmask->removeFlag(16);
        $this->assertEquals(4, $bitmask->getBitmask());
        $this->assertFalse($bitmask->hasFlag(16));

        $bitmask->removeFlag(4 | 1);
        $this->assertEquals(0, $bitmask->getBitmask());

        $bitmask->setBitmask(11);
        $bitmask->removeFlag(2 | 1);
        $this->assertEquals(8, $bitmask->getBitmask());
        $this->assertFalse($bitmask->hasFlag(1));
        $this->assertFalse($bitmask->hasFlag(2));
        $this->assertFalse($bitmask->hasFlag(1 | 2));
        $this->assertFalse($bitmask->hasFlag(2 | 1));
    }

}
