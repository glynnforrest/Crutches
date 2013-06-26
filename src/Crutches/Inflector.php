<?php

namespace Crutches;

/**
 * Inflector
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
abstract class Inflector {

	public function plural($string) {
		if(in_array($string, $this->ignored)) {
			return $string;
		}
		foreach($this->plurals as $pattern => $plural) {
			if(preg_match($pattern, $string)) {
				return preg_replace($pattern, $plural, $string);
			}
		}
	}

	public function single($string) {
		if(in_array($string, $this->ignored)) {
			return $string;
		}
		foreach($this->singles as $pattern => $single) {
			if(preg_match($pattern, $string)) {
				return preg_replace($pattern, $single, $string);
			}
		}
		return $string;
	}

}
