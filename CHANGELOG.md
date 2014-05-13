Changelog
=========

### 0.2.2 2014-05-13

Adding MIT license.

### 0.2.1 2014-05-12

Major improvements in the ItemList class.

* All ItemList methods have the option to either return a new ItemList
  instance or edit the current list. The default is to return a new
  instance to reduce side effects.
* Adding a MutableItemList that changes the current list by default.
* Adding ItemList takeRandom().
* Adding ItemList shuffle().

### 0.2.0 2013-12-31

* Adding the Bitmask class for working with a bitwise value system (e.g. user permissions).
* Adding the DotArray merge() function().

### 0.1.2 2013-11-27

* Some small additions to the Inflector/EN word base.
* Adding the locale function to Inflector.

### 0.1.1 2013-11-27

Internal release, adding the RMT build tool.

### 0.1.0 2013-11-27

Initial release. Included classes are:

* Inflector for plurals (currently the only locale is EN).
* DotArray for easy access to nested array values.
* ItemList for manipulating lists.
