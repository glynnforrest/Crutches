<?php

namespace Crutches;

/**
 * Convert integers to and from roman numerals.
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class Roman
{
    protected static $characters = array(
        1000 => 'M',
        900 => 'CM',
        500 => 'D',
        400 => 'CD',
        100 => 'C',
        90 => 'XC',
        50 => 'L',
        40 => 'XL',
        10 => 'X',
        9 => 'IX',
        5 => 'V',
        4 => 'IV',
        1 => 'I',
    );

    /**
     * Convert an integer to a roman numeral.
     *
     * @param int $int
     *
     * @return string
     */
    public static function toRoman($int)
    {
        $roman = '';
        foreach (self::$characters as $number => $character) {
            while ($int >= $number) {
                $roman .= $character;
                $int -= $number;
            }
        }

        return $roman;
    }
}
