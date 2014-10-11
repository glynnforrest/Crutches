<?php

namespace Crutches;

/**
 * Inflector
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
abstract class Inflector
{
    /**
     * A list of ignored words, where singular = plural
     */
    protected $ignored = array();

    /**
     * An array where keys are a regexp matching the singular, and
     * values are the corresponding regexp replacement to make the
     * plural.
     */
    protected $plurals = array();

    /**
     * An array where keys are a regexp matching the plural, and
     * values are the corresponding regexp replacement to make the
     * singular.
     */
    protected $singles = array();

    /**
     * Return the plural form of $singular.
     *
     * @param string $singular The singular word.
     */
    public function plural($singular)
    {
        if (in_array($singular, $this->ignored)) {
            return $singular;
        }
        foreach ($this->plurals as $pattern => $plural) {
            if (preg_match($pattern, $singular)) {
                return preg_replace($pattern, $plural, $singular);
            }
        }
    }

    /**
     * Return the singular form of $plural.
     *
     * @param string $plural The plural word.
     */
    public function single($plural)
    {
        if (in_array($plural, $this->ignored)) {
            return $plural;
        }
        foreach ($this->singles as $pattern => $single) {
            if (preg_match($pattern, $plural)) {
                return preg_replace($pattern, $single, $plural);
            }
        }

        return $plural;
    }

    /**
     * Get an instance of the Inflector $locale, which defaults to
     * EN. An exception will be thrown if $locale can't be found.
     */
    public static function locale($locale = 'EN')
    {
        $class = '\\Crutches\\Inflector\\' . $locale;
        if (!class_exists($class)) {
            throw new \Exception("Unable to load Inflector class $class");
        }

        return new $class();
    }

}
