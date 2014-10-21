NamedBitmask
============

Like the NamedBitmask class, the NamedBitmask class allows for easy bitwise
manipulation of an integer value. With a NamedBitmask however, you can
refer to the flags by names rather than the underlying bits. A good
application of this could be for UserPermissions. The entire
permission set could be stored as a single integer, and each
permission could be checked and manipulated with names rather than
integers.

## Quick example

```php
$mask = new NamedBitmask(array('CREATE', 'READ', 'UPDATE', 'DELETE'), 7);

$mask->hasFlag('READ');
// true

$mask->hasFlag('DELETE');
// false

$mask->addFlag('DELETE');
$mask->removeFlag('READ');

$mask->hasFlag('READ');
// false

$mask->hasFlag('DELETE');
// true

echo $mask->getBitmask();
// 13
// The underlying values are
// CREATE -> 1, READ -> 2, UPDATE -> 4, DELETE -> 8
// but this is abstracted away for you.
```

## Methods

### getBitmask

$mask->getBitmask()

Get the bitmask value.

```php
$mask = new NamedBitmask(array(), 5);
echo $mask->getBitmask();
// 5
```

### setBitmask

$mask->setBitmask(int $bitmask)

Set the bitmask value.

```php
$mask = new NamedBitmask(array(), 4);
$mask->setBitmask(5);
echo $mask->getBitmask();
// 5
```

### getNames

$mask->getNames()

Get the names of bitmask flags.

```php
$mask = new NamedBitmask(array('ADMIN', 'USER'), 1);
print_r($mask->getNames());
// array('ADMIN', 'USER');
```

### setNames

$mask->setNames(array $names, bool $update_bitmask = true)

Set the names of bitmask flags. The currently set bitmask flags will
be preserved unless $update_bitmask is set to false.

```php
$mask = new NamedBitmask(array('CAN_VIEW', 'CAN_CREATE', 'CAN_EDIT', 'CAN_DELETE'));
$mask->addFlag(array('CAN_CREATE', 'CAN_VIEW'));

echo $mask->getBitmask()
// 3
print_r($mask->getFlags());
// array('CAN_VIEW', 'CAN_CREATE');

$mask->setNames(array('CAN_DELETE', 'CAN_CREATE', 'CAN_VIEW', 'CAN_EDIT', 'IS_ADMIN'));
print_r($mask->getNames());
// array('CAN_DELETE', 'CAN_CREATE', 'CAN_VIEW', 'CAN_EDIT', 'IS_ADMIN');

// the bitmask is updated to keep the flags the same
echo $mask->getBitmask()
// 6
print_r($mask->getFlags());
// array('CAN_CREATE, 'CAN_VIEW);
```

### hasFlag

$mask->hasFlag(string $flag)

Check if the NamedBitmask contains a given flag.

Check more than one flag at a time by passing flags as an array.

```php
$mask = new NamedBitmask(array('ADMIN', 'USER'), 1);
$mask->hasFlag('ADMIN');
// true
```

### addFlag

$mask->addFlag(mixed $flag)

Add a flag to the NamedBitmask.

Add more than one flag at a time by passing flags as an array.

```php
$mask = new NamedBitmask(array('ADMIN', 'USER'), 0);
$mask->addFlag('USER');
echo $mask->getBitmask();
// 2
```

### removeFlag

$mask->removeFlag(mixed $flag)

Remove a flag from the NamedBitmask.

Remove more than one flag at a time by passing flags as an array.

```php
$mask = new NamedBitmask(array('ADMIN', 'USER'), 1);
$mask->removeFlag('ADMIN');
echo $mask->getBitmask();
// 0
```

### getFlags

$mask->getFlags()

Get a list of all set flags.

```php
$mask = new NamedBitmask(array('CAN_VIEW', 'CAN_CREATE', 'CAN_EDIT', 'CAN_DELETE'));
$mask->addFlag('CAN_CREATE');
print_r($mask->getFlags());
// array('CAN_CREATE')

$mask->addFlag(array('CAN_VIEW', 'CAN_DELETE');
print_r($mask->getFlags());
// array('CAN_VIEW', 'CAN_CREATE', 'CAN_DELETE')
```
