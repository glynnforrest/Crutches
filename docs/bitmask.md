Bitmask
=======

This class allows for easy bitwise manipulation of an integer value.

## Quick example

```php
$mask = new Bitmask(5);

$mask->hasFlag(1);
// true

$mask->hasFlag(2);
// false

$mask->addFlag(2);
$mask->removeFlag(1);

$mask->hasFlag(1);
// false

$mask->hasFlag(2);
// true

echo $mask->getBitmask();
// 6
```

## Methods

### getBitmask

$mask->getBitmask()

Get the bitmask value.

```php
$mask = new Bitmask(5);
echo $mask->getBitmask();
// 5
```

### setBitmask

$mask->setBitmask(int $bitmask)

Set the bitmask value.

```php
$mask = new Bitmask(4);
$mask->setBitmask(5);
echo $mask->getBitmask();
// 5
```

### hasFlag

$mask->hasFlag(int $flag)

Check if the Bitmask contains a given flag.

Check more than one flag at a time by separating individual
flags with |. For example, supplying 4 | 1 will check for both
4 and 1, and will pass only if both 4 and 1 are present.

```php
$mask = new Bitmask(4);
$mask->hasFlag(4);
// true
```

### addFlag

$mask->addFlag(int $flag)

Add a flag to the Bitmask.

Add more than one flag at a time by separating individual
flags with |. For example, supplying 4 | 1 will add both 4
and 1.

```php
$mask = new Bitmask(4);
$mask->addFlag(1);
echo $mask->getBitmask();
// 5
```

### removeFlag

$mask->removeFlag(int $flag)

Remove a flag from the Bitmask.

Remove more than one flag at a time by separating individual
flags with |. For example, supplying 4 | 1 will remove both 4
and 1.

```php
$mask = new Bitmask(5);
$mask->removeFlag(4);
echo $mask->getBitmask();
// 1
```
