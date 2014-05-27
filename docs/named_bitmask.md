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

## Methods

### getBitmask

$mask->getBitmask()

Get the bitmask value.

    $mask = new NamedBitmask(array(), 5);
    echo $mask->getBitmask();
    // 5

### setBitmask

$mask->setBitmask(int $bitmask)

Set the bitmask value.

    $mask = new NamedBitmask(array(), 4);
    $mask->setBitmask(5);
    echo $mask->getBitmask();
    // 5

### getNames

$mask->getNames()

Get the names of bitmask flags.

    $mask = new NamedBitmask(array('ADMIN', 'USER'), 1);
    print_r($mask->getNames());
    // array('ADMIN', 'USER');

### setNames

$mask->setNames(array $names)

Set the names of bitmask flags.

    $mask = new NamedBitmask(array('ADMIN', 'USER'), 1);
    $mask->setName(array('ADMIN', 'PLEB));
    print_r($mask->getNames());
    // array('ADMIN', 'PLEB');

### hasFlag

$mask->hasFlag(string $flag)

Check if the NamedBitmask contains a given flag.

Check more than one flag at a time by separating individual
flags with |. For example, supplying 4 | 1 will check for both
4 and 1, and will pass only if both 4 and 1 are present.

    $mask = new NamedBitmask(array('ADMIN', 'USER'), 1);
    $mask->hasFlag('ADMIN');
    // true

### addFlag

$mask->addFlag(string $flag)

Add a flag to the NamedBitmask.

Add more than one flag at a time by separating individual
flags with |. For example, supplying 4 | 1 will add both 4
and 1.

    $mask = new NamedBitmask(array('ADMIN', 'USER'), 0);
    $mask->addFlag('USER');
    echo $mask->getBitmask();
    // 2

### removeFlag

$mask->removeFlag(string $flag)

Remove a flag from the NamedBitmask.

Remove more than one flag at a time by separating individual
flags with |. For example, supplying 4 | 1 will remove both 4
and 1.

    $mask = new NamedBitmask(array('ADMIN', 'USER'), 1);
    $mask->removeFlag('ADMIN');
    echo $mask->getBitmask();
    // 0
