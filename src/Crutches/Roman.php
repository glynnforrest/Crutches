<?php

namespace Crutches;

/**
 * Convert integers to roman numerals and back again.
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
        if (!is_int($int) || $int < 1 || $int > 3999) {
            throw new \InvalidArgumentException("A roman numeral must be an integer between 1 and 3999, $int given.");
        }

        $roman = '';
        foreach (self::$characters as $number => $character) {
            while ($int >= $number) {
                $roman .= $character;
                $int -= $number;
            }
        }

        return $roman;
    }

    /**
     * Convert a roman numeral to an integer.
     *
     * @param string $roman
     *
     * @return int
     */
    public static function toInt($roman)
    {
        if (!preg_match('`[MDCLXVI]+`', strtoupper($roman))) {
            throw new \InvalidArgumentException("$roman is an invalid roman numeral.");
        }
        $roman = strtoupper($roman);

        $characters = array_flip(self::$characters);

        $int = 0;
        while (strlen($roman) > 0) {
            if (isset($characters[substr($roman, 0, 2)])) {
                $int += $characters[substr($roman, 0, 2)];
                $roman = substr($roman, 2);
                continue;
            }
            if (isset($characters[substr($roman, 0, 1)])) {
                $int += $characters[substr($roman, 0, 1)];
                $roman = substr($roman, 1);
                continue;
            }
        }

        return $int;
    }
}
