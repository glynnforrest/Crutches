<?php

namespace Crutches\Tests;

use Crutches\Roman;

/**
 * RomanTest
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class RomanTest extends \PHPUnit_Framework_TestCase
{
    public function dataProvider()
    {
        return array(
            array(1, 'I'),
            array(2, 'II'),
            array(3, 'III'),
            array(4, 'IV'),
            array(5, 'V'),
            array(6, 'VI'),
            array(7, 'VII'),
            array(8, 'VIII'),
            array(9, 'IX'),
            array(10, 'X'),
            array(50, 'L'),
            array(100, 'C'),
            array(500, 'D'),
            array(1000, 'M'),
            array(31, 'XXXI'),
            array(148, 'CXLVIII'),
            array(294, 'CCXCIV'),
            array(312, 'CCCXII'),
            array(421, 'CDXXI'),
            array(528, 'DXXVIII'),
            array(621, 'DCXXI'),
            array(782, 'DCCLXXXII'),
            array(870, 'DCCCLXX'),
            array(941, 'CMXLI'),
            array(1043, 'MXLIII'),
            array(1110, 'MCX'),
            array(1226, 'MCCXXVI'),
            array(1301, 'MCCCI'),
            array(1485, 'MCDLXXXV'),
            array(1509, 'MDIX'),
            array(1607, 'MDCVII'),
            array(1754, 'MDCCLIV'),
            array(1832, 'MDCCCXXXII'),
            array(1993, 'MCMXCIII'),
            array(2074, 'MMLXXIV'),
            array(2152, 'MMCLII'),
            array(2212, 'MMCCXII'),
            array(2343, 'MMCCCXLIII'),
            array(2499, 'MMCDXCIX'),
            array(2574, 'MMDLXXIV'),
            array(2646, 'MMDCXLVI'),
            array(2723, 'MMDCCXXIII'),
            array(2892, 'MMDCCCXCII'),
            array(2975, 'MMCMLXXV'),
            array(3051, 'MMMLI'),
            array(3185, 'MMMCLXXXV'),
            array(3250, 'MMMCCL'),
            array(3313, 'MMMCCCXIII'),
            array(3408, 'MMMCDVIII'),
            array(3501, 'MMMDI'),
            array(3610, 'MMMDCX'),
            array(3743, 'MMMDCCXLIII'),
            array(3844, 'MMMDCCCXLIV'),
            array(3888, 'MMMDCCCLXXXVIII'),
            array(3940, 'MMMCMXL'),
            array(3999, 'MMMCMXCIX')
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testToRoman($int, $roman)
    {
        $this->assertSame($roman, Roman::toRoman($int));
    }
}
