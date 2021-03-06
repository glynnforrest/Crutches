<?php

namespace Crutches;

/**
 * NamedBitmask
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class NamedBitmask implements \IteratorAggregate
{
    protected $bitmask;
    protected $names = array();

    /**
     * Create a new Bitmask instance.
     *
     * @param array $name    An array of named flags
     * @param int   $bitmask The bitmask
     */
    public function __construct(array $names, $bitmask = 0)
    {
        $this->bitmask = $bitmask;
        $this->setNames($names, false);
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
     * @param  int                   $bitmask The bitmask
     * @return Crutches\NamedBitmask This NamedBitmask instance
     */
    public function setBitmask($bitmask)
    {
        $this->bitmask = $bitmask;

        return $this;
    }

    /**
     * Get the names of bitmask flags.
     *
     * @return array An array of flag names
     */
    public function getNames()
    {
        return array_keys($this->names);
    }

    /**
     * Set the names of bitmask flags. The currently set bitmask flags
     * will be preserved unless $update_bitmask is set to false.
     *
     * @param  array                 $names          An array of flag names
     * @param  bool                  $update_bitmask Update the value of the bitmask to match the cnew flags
     * @return Crutches\NamedBitmask This NamedBitmask instance
     */
    public function setNames(array $names, $update_bitmask = true)
    {
        //take note of any current flags to update the bitmask.
        if ($update_bitmask) {
            $current_flags = $this->getFlags();
        }

        //each name will have an incrementing bit value, e.g. an array
        //of 3 will have values of 1, 2 and 4
        $bits = array();
        $bit = 1;
        $count = count($names);
        for ($i = 0; $i < $count; $i++) {
            $bits[] = $bit;
            $bit *= 2;
        }

        //necessary for 5.3 array_combine with empty arrays
        if ($count > 0) {
            $this->names = array_combine($names, $bits);
        }

        // update the bitmask now that new names are set.
        if ($update_bitmask) {
            $this->bitmask = 0;
            $this->addFlag($current_flags);
        }

        return $this;
    }

    protected function getMaskFromFlags($flags)
    {
        $flags = (array) $flags;
        $mask = 0;
        foreach ($flags as $flag) {
            if (!isset($this->names[$flag])) {
                throw new \Exception(sprintf('Named flag not found: "%s"', $flag));
            }
            $mask = $mask | $this->names[$flag];
        }

        return $mask;
    }

    /**
     * Check if the NamedBitmask contains a given flag.
     *
     * Check more than one flag at a time by passing flags as an array.
     *
     * @param  mixed $flags The flag to check as a string, or multiple flags as an array
     * @return bool  The result of the check
     */
    public function hasFlag($flags)
    {
        $mask = $this->getMaskFromFlags($flags);

        return ($this->bitmask & $mask) === $mask;
    }

    /**
     * Add a flag to the NamedBitmask.
     *
     * Add more than one flag at a time by passing flags as an array.
     *
     * @param  mixed            $flags The flag to add as a string, or multiple flags as an array
     * @return Crutches\Bitmask This Bitmask instance
     */
    public function addFlag($flags)
    {
        $this->bitmask = $this->bitmask | $this->getMaskFromFlags($flags);

        return $this;
    }

    /**
     * Remove a flag from the NamedBitmask.
     *
     * Remove more than one flag at a time by passing flags as an array.
     *
     * @param  mixed            $flags The flag to remove as a string, or multiple flags as an array
     * @return Crutches\Bitmask This Bitmask instance
     */
    public function removeFlag($flags)
    {
        $this->bitmask = $this->bitmask & ~$this->getMaskFromFlags($flags);

        return $this;
    }

    /**
     * Get a list of all set flags.
     *
     * @return array A list of all set flags
     */
    public function getFlags()
    {
        $flags = array();
        foreach ($this->names as $name => $bit) {
            if (($this->bitmask & $bit) === $bit) {
                $flags[] = $name;
            }
        }

        return $flags;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getFlags());
    }
}
