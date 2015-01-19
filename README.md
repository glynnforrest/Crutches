# Crutches
## A PHP utility library

[![Build Status](https://img.shields.io/travis/glynnforrest/Crutches/master.svg)](https://travis-ci.org/glynnforrest/Crutches)
[![Packagist](http://img.shields.io/packagist/v/glynnforrest/Crutches.svg)](https://packagist.org/packages/glynnforrest/Crutches)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)

Included classes:

* DotArray - Set and get values from complex array structures easily.
* ItemList - Manipulate a list of objects (arrays with numeric
  keys). Methods are inspired by functional concepts such as map,
  filter and take. All methods that operate on the list return a new
  instance, leaving the original list unchanged.
* MutableItemList - The same as ItemList, except all methods modify
  the object instead of returning a new instance.
* Bitmask - A series of flags used to represent a group of properties
  (e.g. user permissions).
* NamedBitmask - An extension of Bitmask that abstracts numeric flags
  away from the user, instead referring to named flags.

See the docs/ directory for detailed usage on each.

## Installation

Crutches is installed via Composer. To add it to your project, simply add it to your
composer.json file:

```json
{
    "require": {
        "glynnforrest/crutches": "0.3.*"
    }
}
```

And run composer to update your dependencies:

```bash
curl -s http://getcomposer.org/installer | php
php composer.phar update
```

## License

MIT
