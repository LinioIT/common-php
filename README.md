# Linio Common
[![Latest Stable Version](https://poser.pugx.org/linio/common/v/stable.svg)](https://packagist.org/packages/linio/common) [![License](https://poser.pugx.org/linio/common/license.svg)](https://packagist.org/packages/linio/common) [![Build Status](https://secure.travis-ci.org/LinioIT/common.png)](http://travis-ci.org/LinioIT/common) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LinioIT/common/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LinioIT/common/?branch=master)

Linio Common contains small components that either extend PHP's functionality or provide
a coherent base for Linio components:

* Common & Collection Types

## Install

The recommended way to install Linio Common is [through composer](http://getcomposer.org).

```
$ composer require linio/common
```

## Tests

To run the test suite, you need install the dependencies via composer, then
run PHPUnit.

    $ composer install
    $ vendor/bin/phpunit

## Collections

This component has a direct dependency on doctrine/collections. You are encouraged
to use them since they are also used as base for most our own custom collection types.

#### Dictionary

This data structure allows you to create coherent key-value pairs, that can be used
in an idiomatic way:

```php
<?php

use Linio\Common\Type\Dictionary;

$dict = new Dictionary(['foo' => 'bar']);

if ($dict->has('foo')) {
    echo $dict->get('foo');
}

echo $dict->get('i_dont_exist'); // null
echo $dict->get('i_dont_exist', 'default'); // default

if ($dict->contains('bar')) {
    echo 'We have a bar value somewhere!';
}

```

#### TypedCollection

This collection allows you to guarantee type-safety when working with `ArrayCollection` by
implementing a type validation method. For example:

```php
<?php

use Linio\Common\Type\Collection\TypedCollection;

class UserCollection extends TypedCollection
{
    public function isValidType($value): bool
    {
        return $value instanceof User;
    }
}
```
