# Package axelitus/base

A framework agnostic PHP package that contains _extensions_ and helpers for the PHP primitive types (strings, numbers, array, etc.). It also contains common interfaces for _new_ types like dot-notated arrays, collections, etc.

## Package Information

* **Package:** axelitus/base [![Dependencies Status](http://depending.in/axelitus/php-base.png)](http://depending.in/axelitus/php-base) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/axelitus/php-base/badges/quality-score.png?s=9dd3b992bc2e6984a108deb40dcb85c9af9451ec)](https://scrutinizer-ci.com/g/axelitus/php-base/) [![Total Downloads](https://poser.pugx.org/axelitus/base/downloads.svg)](https://packagist.org/packages/axelitus/base) [![License](https://poser.pugx.org/axelitus/base/license.svg)](https://packagist.org/packages/axelitus/base) [![Project Status](https://stillmaintained.com/axelitus/php-base.svg)](https://stillmaintained.com/axelitus/php-base)
* **Root Namespace:** axelitus\Base
* **Author:** Axel Pardemann (axelitusdev@gmail.com)
* **Repository**: [axelitus/php-base](https://github.com/axelitus/php-base "axelitus/php-base at GitHub") at GitHub
* **Build Status (master):** [![Build Status](https://secure.travis-ci.org/axelitus/php-base.png?branch=master)](http://travis-ci.org/axelitus/php-base) [![Latest Stable Version](https://poser.pugx.org/axelitus/base/v/stable.svg)](https://packagist.org/packages/axelitus/base) [![Coverage Status](https://coveralls.io/repos/axelitus/php-base/badge.png?branch=master)](https://coveralls.io/r/axelitus/php-base)
* **Build Status (develop):** [![Build Status](https://secure.travis-ci.org/axelitus/php-base.png?branch=develop)](http://travis-ci.org/axelitus/php-base) [![Latest Unstable Version](https://poser.pugx.org/axelitus/base/v/unstable.svg)](https://packagist.org/packages/axelitus/base) [![Coverage Status](https://coveralls.io/repos/axelitus/php-base/badge.png?branch=develop)](https://coveralls.io/r/axelitus/php-base)
* **Composer Package:** [axelitus/base](http://packagist.org/packages/axelitus/base "axelitus/base at Packagist") at Packagist
* **Issue Tracker:** [axelitus/php-base](https://github.com/axelitus/php-base/issues "axelitus/php-base Issue Tracker at GitHub") Issue Tracker at GitHub

## Requirements

The requirements for this package to work are the following:

* PHP >= 5.4.9 (it may work for previous 5.4.X versions but it is not tested).

## Standards

This package is intended to follow some standards for easy contributions and usage. Recently there has been an initiative to standardize the interoperation of frameworks, though I think this easily extends to most pieces of code everyone is building. The group behind all this is the [PHP-FIG (Framework Interoperability Group)](http://www.php-fig.org), you should pay them a visit at their site.

There are already some standards marked as accepted (_final_): [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md), [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md), [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md), [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md).

**This package is intended to be PSR-2/PSR-4 compliant.**

Being PSR-2/PSR-4 compliant means this package follows a [guide for coding styles](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) and the developers and contributors should enforce this for everyone's benefit. It also means that it can be easily installed by using [Composer](getcomposer.org) from the [Packagist](http://packagist.org) package archive. Just follow the instructions in section [How to install](#how-to-install).

## Contents

##### axelitus\Base

 - **Arr** - Dot-notated array object.
 - **BigFloat** - Float operations for big numbers.
 - **BigInt** - Int operations for big numbers.
 - **BigNum** - Numeric operations for big numbers.
 - **Bool** - Boolean operations.
 - **BoolAnd** - Boolean AND operations on values and arrays.
 - **BoolEq** - Boolean EQ operations on values and arrays.
 - **BoolNot** - Boolean NOT operations on values and arrays.
 - **BoolOr** - Boolean OR operations on values and arrays.
 - **BoolXor** - Boolean XOR operations on values and arrays.
 - **Comparable** - Defines the interface for a comparable object.
 - **Comparer** - Simple and flexible base comparer from which new comparers should be derived.
 - **DotArr** - Dot-notated array operations.
 - **Flag** - Bitwise flag operations.
 - **Float** - Float operations.
 - **Initiable** - Defines the interface for initiable classes (simulates a static constructor).
 - **Int** - Int operations.
 - **Num** - Numeric operations.
 - **PropertyAccessible** - Allows derived class to use object property access syntax just be defining getters and setters.
 - **Str** - String operations.
 - **Traverser** - Array callback traverser.

##### axelitus\Base\Comparison
 - **BigFloatComparer** - BigFloat comparer implementation.
 - **BigIntComparer** - BigInt comparer implementation.
 - **BigNumComparer** - BigNum comparer implementation.
 - **BoolComparer** - Bool comparer implementation.
 - **FloatComparer** - Float comparer implementation.
 - **IntComparer** - Int comparer implementation.
 - **StrComparer** - Str comparer implementation.

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
