ItemList
========

This class takes a list of items and transforms that list through
functional - style methods.

## Quick example

    $list = new \Crutches\ItemList(array('foo', 'bar', 'baz'));

    print_r($list->surround('-')->map('strtoupper')->takeRandom(1));
    // array('-BAR-');

    print_r($list->shuffle()->prefix(':'));
    // array(':bar', ':baz', ':foo');

    echo $list;
    // "foo, bar, baz"

    echo $list->human();
    // foo, bar and baz

## Methods

Note - all of these methods work the same way in MutableItemList
too. The only difference is ItemList returns a new instance every
time, whereas MutableItemList modifies itself.

In addition to this, most ItemList methods have an optional final
argument to return the current instance instead of a new one. Pass
true to any method that takes an $in_place argument to return the same
instance.

Most of these methods allow for method chaining to keep your code clean.

### create

ItemList::create(array $list = array())

Start chaining methods immediately after creation.

    $shuffled = ItemList::create(array('foo', 'bar'))->shuffle();

### getList

$list->getList()

Get the underlying list as an array.

    $list = new ItemList(array('one', 'two'));
    print_r($list->getList());
    // array('foo', 'bar');

### get

$list->get(int $index)

Get an element at the specific index or null if the index is out of
range. Like arrays, the list is zero-indexed.

    $list = new ItemList(array('one', 'two'));
    echo $list->get(1);
    // bar

    echo $list->get(5);
    // null

### prefix

$list->prefix(string $string, $in_place = false)

Prepend a string to all elements.

    $list = new ItemList(array('one', 'two'));
    print_r($list->prefix('item ')->getList());
    // array('item one', 'item two')

### suffix

$list->suffix(string $string, $in_place = false)

Append a string to all elements.

    $list = new ItemList(array('one', 'two'));
    print_r($list->suffix('potato')->getList());
    // array('one potato', 'two potato')

### surround

$list->surround(string $string, $in_place = false)

Append and prepend a string to all elements.

    $list = new ItemList(array('one', 'two'));
    print_r($list->surround(':')->getList());
    // array(':one:', ':two:')
