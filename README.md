# Package axelitus/base

A framework agnostic PHP package that contains _extensions_ and helpers for the PHP primitive types (strings, numbers, array, etc.). It also contains common interfaces for _new_ types like dot-notated arrays, collections, etc.

## Package Information

* **Package:** axelitus/base [![Total Downloads](https://poser.pugx.org/axelitus/base/downloads.png)](https://packagist.org/packages/axelitus/base) [![Dependencies Status](https://depending.in/axelitus/php-base.png)](http://depending.in/axelitus/php-base)
* **Root Namespace:** axelitus\Base
* **Author:** Axel Pardemann (axelitusdev@gmail.com)
* **Repository**: [axelitus/php-base](https://github.com/axelitus/php-base "axelitus/php-base at GitHub") at GitHub
* **Build Status (master):** [![Build Status](https://secure.travis-ci.org/axelitus/php-base.png?branch=master)](http://travis-ci.org/axelitus/php-base) [![Latest Stable Version](https://poser.pugx.org/axelitus/base/v/stable.png)](https://packagist.org/packages/axelitus/base) [![Coverage Status](https://coveralls.io/repos/axelitus/php-base/badge.png?branch=master)](https://coveralls.io/r/axelitus/php-base) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/axelitus/php-base/badges/quality-score.png?s=a81596bb8923c07e0962acc3ffe7ef986bc5dd98)](https://scrutinizer-ci.com/g/axelitus/php-base/)
* **Build Status (develop):** [![Build Status](https://secure.travis-ci.org/axelitus/php-base.png?branch=develop)](http://travis-ci.org/axelitus/php-base) [![Latest Unstable Version](https://poser.pugx.org/axelitus/base/v/unstable.png)](https://packagist.org/packages/axelitus/base) [![Coverage Status](https://coveralls.io/repos/axelitus/php-base/badge.png?branch=develop)](https://coveralls.io/r/axelitus/php-base)
* **Composer Package:** [axelitus/base](http://packagist.org/packages/axelitus/base "axelitus/base at Packagist") at Packagist
* **Issue Tracker:** [axelitus/php-base](https://github.com/axelitus/php-base/issues "axelitus/php-base Issue Tracker at GitHub") Issue Tracker at GitHub

## Requirements

The requirements for this package to work are the following:

* PHP >= 5.4.9 (it may work for previous 5.4.X versions but it is not tested).

## Standards

This package is intended to follow some standards for easy contributions and usage. Recently there has been an initiative to standardize the interoperation of frameworks, though I think this easily extends to most pieces of code everyone is building. The group behind all this is the [PHP-FIG (Framework Interoperability Group)](http://www.php-fig.org), you should pay them a visit at their site.

There are already some standards marked as accepted (_final_): [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md), [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) and [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).

**This package is intended to be PSR-2 compliant.**

Being PSR-2 compliant means this package can be easily installed by using [Composer](getcomposer.org) from the [Packagist](http://packagist.org) package archive. Just follow the instructions in section [How to install](#how-to-install). It also means that there's a [guide for coding styles](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) and the developers and contributors should enforce this for everyone's benefit.

## Contents

All classes are referenced from the package namespace if not otherwise stated.

 - **Arr** - Dot-notated array object.
 - **BigFloat** - Float operations for big numbers.
 - **BigInt** - Int operations for big numbers.
 - **BigNum** - Numeric operations for big numbers.
 - **Bool** - Boolean operations.
 - **DotArr** - Dot-notated array operations.
 - **Float** - Float operations.
 - **Int** - Int operations.
 - **Num** - Numeric operations.
 - **Str** - String operations.

 ## Features & Roadmap

 - [TODO] New private functions for the Bool class to handle each input data case independently and therefore reduce the complexity rating.
 - [TODO] Try to reduce the complexity rating from the DotArr functions.
 - [TODO] Add the Initiable interface for classes that can/should be initiated.
 - [TODO] Define how to iterate through a dot-notated array.
     - [TODO] Implement the Iterator interface to the Arr class.
 - [TODO] Add a Flag class to handle numeric/boolena flag operations.
     - [TODO] set() function.
     - [TODO] isOn() function.
     - [TODO] isOff() function.
     - [TODO] mask() function.
 - [TODO] Add an abstract 'magic' class that allows for derived class object's to use setters and getters with property syntax through the __set() and __get() magic methods.
 - ~~[DONE]~~ Add a Traversor (or any other name) class that applies a callback to the items of an array. This class behaves somewhat like array_map() and/or array_walk() but it's more flexible.
 

## How to install

To install this package and use it in your app just follow these instructions (if you haven't read the documentation from [Composer](http://getcomposer.org) please do so before you continue):

1. Download composer if you haven't already done so (use your preferred method). Example:
```
    $ curl -s https://getcomposer.org/installer | php
```

2. Place a `require` statement inside your `composer.json` file replacing `<version>` with the desired version. Example:
```
    "require": {
        "axelitus/base": "<version>"
    }
```

3. Run the composer installer to resolve dependencies and download the packages. Example:
```
    $ php composer.phar install
```

4. In order to use the packages you have to _load_ the autoloader that was generated by composer (if you are using a framework, maybe this is already done automatically). Example:
```
    require 'vendor/autoload.php';
```

5. Finally just use the package classes as needed:
```
    axelitus\Base\[<sub-namespace>\...]<class>::<function>(<params>);
```
