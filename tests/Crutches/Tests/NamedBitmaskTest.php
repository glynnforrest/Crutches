<?php

namespace Crutches\Tests;

use Crutches\NamedBitmask;

/**
 * NamedBitmaskTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class NamedBitmaskTest extends \PHPUnit_Framework_TestCase
{

    public function testSetAndGetBitmask()
    {
        $mask = new NamedBitmask(array(), 4);
        $this->assertSame(4, $mask->getBitmask());
        $mask->setBitmask(5);
        $this->assertSame(5, $mask->getBitmask());
    }

    public function testSetAndGetNames()
    {
        $mask = new NamedBitmask(array('ADMIN', 'MODERATOR'));
        $this->assertSame(array('ADMIN', 'MODERATOR'), $mask->getNames());
        $this->assertSame($mask, $mask->setNames(array('ADMIN')));
        $this->assertSame(array('ADMIN'), $mask->getNames());
    }

    public function testSetAndGetEmptyNames()
    {
        $mask = new NamedBitmask(array());
        $this->assertSame(array(), $mask->getNames());
    }

    public function testHasFlag()
    {
        $mask = new NamedBitmask(array('ADMIN', 'MODERATOR'), 0);
        $this->assertFalse($mask->hasFlag('ADMIN'));
        $this->assertFalse($mask->hasFlag('MODERATOR'));
        $this->assertFalse($mask->hasFlag(array('MODERATOR', 'ADMIN')));
        $this->assertFalse($mask->hasFlag(array('ADMIN', 'MODERATOR')));

        //add admin role
        $mask->setBitmask(1);
        $this->assertTrue($mask->hasFlag('ADMIN'));
        $this->assertFalse($mask->hasFlag('MODERATOR'));
        $this->assertFalse($mask->hasFlag(array('MODERATOR', 'ADMIN')));
        $this->assertFalse($mask->hasFlag(array('ADMIN', 'MODERATOR')));

        //add moderator role
        $mask->setBitmask(3);
        $this->assertTrue($mask->hasFlag('ADMIN'));
        $this->assertTrue($mask->hasFlag('MODERATOR'));
        $this->assertTrue($mask->hasFlag(array('MODERATOR', 'ADMIN')));
        $this->assertTrue($mask->hasFlag(array('ADMIN', 'MODERATOR')));
    }

    public function testHasFlagUnknown()
    {
        $mask = new NamedBitmask(array('ADMIN', 'MODERATOR'));
        $this->setExpectedException('\Exception', 'Named flag not found: "USER"');
        $mask->hasFlag('USER');
    }

    public function testAddFlag()
    {
        $mask = new NamedBitmask(array('ADMIN', 'MODERATOR', 'EDITOR'));
        $this->assertSame(0, $mask->getBitmask());
        $this->assertSame($mask, $mask->addFlag('ADMIN'));
        $this->assertSame(1, $mask->getBitmask());
        $this->assertSame($mask, $mask->addFlag(array('MODERATOR', 'EDITOR')));
        $this->assertSame(7, $mask->getBitmask());
    }

    public function testAddFlagUnknown()
    {
        $mask = new NamedBitmask(array('ADMIN', 'MODERATOR'));
        $this->setExpectedException('\Exception', 'Named flag not found: "USER"');
        $mask->addFlag('USER');
    }

    public function testRemoveFlag()
    {
        $mask = new NamedBitmask(array('ADMIN', 'MODERATOR', 'EDITOR'), 7);
        $this->assertSame(7, $mask->getBitmask());
        $this->assertSame($mask, $mask->removeFlag('ADMIN'));
        $this->assertSame(6, $mask->getBitmask());
        $this->assertSame($mask, $mask->removeFlag(array('MODERATOR', 'EDITOR')));
        $this->assertSame(0, $mask->getBitmask());
    }

    public function testRemoveFlagUnknown()
    {
        $mask = new NamedBitmask(array('ADMIN', 'MODERATOR'));
        $this->setExpectedException('\Exception', 'Named flag not found: "USER"');
        $mask->removeFlag('USER');
    }

    public function testGetFlags()
    {
        $mask = new NamedBitmask(array('CAN_VIEW', 'CAN_CREATE', 'CAN_EDIT', 'CAN_DELETE'));
        $this->assertSame(array(), $mask->getFlags());
        $mask->addFlag(array('CAN_VIEW', 'CAN_DELETE'));
        $this->assertSame(9, $mask->getBitmask());
        $this->assertSame(array('CAN_VIEW', 'CAN_DELETE'), $mask->getFlags());
        $mask->addFlag(array('CAN_CREATE'));
        $this->assertSame(array('CAN_VIEW', 'CAN_CREATE', 'CAN_DELETE'), $mask->getFlags());
        $mask->removeFlag('CAN_VIEW');
        $this->assertSame(array('CAN_CREATE', 'CAN_DELETE'), $mask->getFlags());
    }

}
