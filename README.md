Linio Common
============
[![Latest Stable Version](https://poser.pugx.org/linio/common/v/stable.svg)](https://packagist.org/packages/linio/common) [![License](https://poser.pugx.org/linio/common/license.svg)](https://packagist.org/packages/linio/common) [![Build Status](https://secure.travis-ci.org/LinioIT/common.png)](http://travis-ci.org/LinioIT/common) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LinioIT/common/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LinioIT/common/?branch=master)

Linio Common contains small components that either extend PHP's functionality or provide
a coherent base for Linio components:

* Service traits
* Controller helper methods
* Base test cases & constraints
* Types, collections
* Exceptions

Install
-------

The recommended way to install Linio Common is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "linio/common": "dev-master"
    }
}
```

Tests
-----

To run the test suite, you need install the dependencies via composer, then
run PHPUnit.

    $ composer install
    $ phpunit

HashMap
-------

This data structure is similar to key-value pair, but allows you to store an object
as the key, unlike normal PHP arrays. Internally, objects are compared using their
unique hash. To help you understand this better:

```php
<?php

use Linio\Type\HashMap;

$obj1 = new \StdClass();
$obj2 = new \StdClass();
$hashMap = new HashMap();
$hashMap->set($obj1, 'foo');
$hashMap->set($obj2, 'bar');

$hashMap->get($obj1); // foo
$hashMap->get($obj2); // bar
```

ValueHashMap
------------

Inheriting from the `HashMap` data structure, this variant allows you to store objects
in exactly the same way, except that objects will be compared by value. A common
use case is:

```php
<?php

use Linio\Type\ValueHashMap;

$firstDay = new \DateTime('2000-01-01 00:00:00');
$secondDay = new \DateTime('2000-01-01 00:00:00');
$thirdDay = new \DateTime('2000-01-20 00:00:00');

$hashMap = new ValueHashMap();
$hashMap->set($secondDay, 'foo');
$hashMap->set($thirdDay, 'bar');

$hashMap->get($firstDay); // foo
$hashMap->get($secondDay); // foo
$hashMap->get($thirdDay); // bar
```

Dictionary
----------

This data structure allows you to create coherent key-value pairs, that can be used
in an idiomatic way:

```php
<?php

use Linio\Type\Dictionary;

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

Collections
-----------

This component has a direct dependency on doctrine/collections. You are encouraged
to use them since they are also used as base for our own custom collection types.

### TypedCollection

This collection allows you to guarantee type-safety when working with `ArrayCollection` by
implementing a type validation method. For example:

```php
<?php

use Linio\Collection\TypedCollection;

class UserCollection extends TypedCollection
{
    public function isValidType($value)
    {
        return ($value instanceof User);
    }
}
```

Controllers
-----------

The base framework includes abstract controllers with a few helper methods
to speedup application development. The `RestController`, for instance, contains
various methods to make developing RESTful API's easier:


```php
<?php

use Linio\Controller\RestController;

class FooController extends RestController
{
    public function barAction()
    {
        // Error output
        if (!$do->something()) {
            $this->abort('Something went wrong');
        }
    }
}
```

Service Traits
--------------

The common library includes service traits, so you can easily inject dependencies
and make use of services in your controllers. There are various controller-specific
traits available:

* `FormAware`: allows you to use the `symfony/form` component and provides helpers
* `RouterAware`: allows you to use the `symfony/routing` component and provides helpers
* `TemplatingAware`: allows you to use the `symfony/templating` component and provides helpers
* `SessionAware`: allows you to use the `symfony/http-foundation/session` component and provides helpers
