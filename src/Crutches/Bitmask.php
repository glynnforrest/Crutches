<?php

namespace Crutches;

/**
 * Bitmask
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class Bitmask
{
    protected $bitmask;

    /**
     * Create a new Bitmask instance.
     *
     * @param int $bitmask The bitmask
     */
    public function __construct($bitmask = 0)
    {
        $this->bitmask = $bitmask;
    }

    /**
     * Get the bitmask value.
     *
     * @return int The bitmask
     */
    public function getBitmask()
    {
        return $this->bitmask;
    }

    /**
     * Set the bitmask value.
     *
     * @param  int              $bitmask The bitmask
     * @return Crutches\Bitmask This Bitmask instance
     */
    public function setBitmask($bitmask)
    {
        $this->bitmask = $bitmask;

        return $this;
    }

    /**
     * Check if the Bitmask contains a given flag.
     *
     * Check more than one flag at a time by separating individual
     * flags with |. For example, supplying 4 | 1 will check for both
     * 4 and 1, and will pass only if both 4 and 1 are present.
     *
     * @param  int  $flag The flag to check
     * @return bool The result of the check
     */
    public function hasFlag($flag)
    {
        return ($this->bitmask & $flag) === $flag;
    }

    /**
     * Add a flag to the Bitmask.
     *
     * Add more than one flag at a time by separating individual
     * flags with |. For example, supplying 4 | 1 will add both 4
     * and 1.
     *
     * @param  int              $flag The flag to add
     * @return Crutches\Bitmask This Bitmask instance
     */
    public function addFlag($flag)
    {
        $this->bitmask = $this->bitmask | $flag;

        return $this;
    }

    /**
     * Remove a flag from the Bitmask.
     *
     * Remove more than one flag at a time by separating individual
     * flags with |. For example, supplying 4 | 1 will remove both 4
     * and 1.
     *
     * @param  int              $flag The flag to remove
     * @return Crutches\Bitmask This Bitmask instance
     */
    public function removeFlag($flag)
    {
        $this->bitmask = $this->bitmask & ~$flag;

        return $this;
    }

}
