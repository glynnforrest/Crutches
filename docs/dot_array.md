DotArray
========

This class makes it easy to set and get values from deeply nested
array structures. An example usage could be a simple configuration
class.

## Quick example

```php
$config = array(
    'foo' => 'hello world',
    'bar' => array(
        'one' => array('foo', 'bar'),
        'two' => 'baz'
    ));

$array = new DotArray($config);

echo $array->get('foo');
// hello world

print_r($array->get('bar.one'));
// array('foo', 'bar');

$array->set('quo', 'hi world');
echo $array->get('quo');
// hi world

print_r($array->get());

/*
array(
    'foo' => 'hello world',
    'bar' => array(
        'one' => array('foo', 'bar'),
        'two' => 'baz'
    ),
    'quo' => 'hi world'
);
*/
```

## Methods

### get

$array->get(string $key = null, mixed $default = null)

Get a value from the array that matches $key. $key uses the dot array
syntax, e.g. parent.child.child. If the key matches an array the whole
array will be returned. If no key is specified the entire array will
be returned. $default will be returned (null unless specified) if the
key is not found.

```php
$array = new DotArray(array('foo' => 1));

echo $array->get('foo');
// 1

echo $array->get('bar');
// null

echo $array->get('bar', 'default');
// 'default'
```

### getFirst

$array->getFirst(string $key = null, mixed $default = null)

Get the first value from an array of values that matches $key.
$default will be returned (null unless specified) if the key is not
found or does not contain an array.

```php
$array = new DotArray(array('foo' => array('one' => 1, 'two' => 2)));

echo $array->getFirst('foo');
// 1

echo $array->getFirst('bar');
// null

echo $array->getFirst('bar', 'default');
// 'default'
```

### set

$array->set(string $key, mixed $value)

Set an array value with $key. $key uses the dot array syntax, e.g.
parent.child.child. If $value is an array this will also be accessible
using the dot array syntax.

```php
$array = new DotArray();

$array->set('foo.bar', 'hello');

print_r($array->get());
// array('foo' => array('bar' => 'hello'))
```

### remove

$array->remove(string $key)

Unset an array value with $key. $key uses the dot array syntax,
e.g. parent.child.child.

```php
$array = new DotArray(array('foo' => array('bar' => 'hello world')));

$array->remove('foo.bar');

print_r($array->get());
// array()
```

### merge

$array->merge(array $array)

Merge values with values from $array. Any conflicting keys will
be overwritten by those in $array.

```php
$array = new DotArray(array('foo' => 'hello world'));

$array->merge(array('bar' => 'quo', 'foo' => 'hi world'));

echo $array->get('bar');
// quo

echo $array->get('foo');
// hi world
