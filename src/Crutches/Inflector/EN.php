<?php

namespace Crutches\Inflector;

use Crutches\Inflector;

/**
 * EN
 *
 * @author Glynn Forrest <me@glynnforrest.com>
 **/
class EN extends Inflector {

	protected $ignored = array(
		'jeans',
		'scissors',
		'fish',
		'sheep'
	);

	protected $plurals = array (
		'`(l|m)ouse`' => '\1ice',
		'`([^aeiou])y$`' => '\1ies',
		'`o$`' => 'oes',
		'`(t|p)us$`' => '\1i',
		'`(a|e|i|o|u)s$`' => '\1ses',
		'`(sh|x|ch)$`' => '\1es',
		'`oose$`' => 'eese',
		'`s$`' => 's',
		'`$`' => 's'
	);

	protected $singles = array(
		'`ies$`' => 'y',
		'`hoes$`' => 'hoe',
		'`((a|e|i|o|u){2})ses$`' => '\1se',
		'`([^l|g])es$`' => '\1',
		'`s$`' => '',
		'`ice$`' => 'ouse',
		'`i$`' => 'us',
		'`eese$`' => 'oose',
	);

}
