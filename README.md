# Linio Common
[![Latest Stable Version](https://poser.pugx.org/linio/common/v/stable.svg)](https://packagist.org/packages/linio/common) [![License](https://poser.pugx.org/linio/common/license.svg)](https://packagist.org/packages/linio/common) [![Build Status](https://secure.travis-ci.org/LinioIT/common.png)](http://travis-ci.org/LinioIT/common) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LinioIT/common/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LinioIT/common/?branch=master)

Linio Common contains small components that either extend PHP's functionality or provide
a coherent base for Linio components:

* Common types
* Base exceptions
* Monolog processors and handlers

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

## Exceptions

These exceptions provide a good base for all domain exceptions. The included interfaces act as tags that
allow the Monolog processors and handlers to interact with them in specified ways.

#### DomainException

This exception is the core exception in which all other library and application (domain) exceptions should
extend. It's used by the exception handlers included in our common libraries for different frameworks.
With this, we can easily support translation of messages, and input errors on a per field basis.

```php
<?php

throw new \Linio\Common\Exception\DomainException(
    'ORDER_COULD_NOT_BE_PROCESSED',
    500,
    'The order could not be processed because the processor is not responding'
);
```

#### ClientException

```php
<?php

throw new \Linio\Common\Exception\ClientException(
    'ORDER_INCOMPLETE',
    400,
    'The order could not be processed because the request is incomplete'
);
```

#### EntityNotFoundException

```php
<?php

throw new \Linio\Common\Exception\EntityNotFoundException(
    'Customer',
    'b3ed5dec-a152-4f38-8726-4c4628a6fdbd'
);
```

```php
<?php

throw new \Linio\Common\Exception\EntityNotFoundException(
    'Postcode',
    ['region' => 'Region 1', 'municipality' => 'Municipality 1']
);
```

```php
<?php

class CustomerNotFoundException extends \Linio\Common\Exception\EntityNotFoundException
{
    public function __construct(string $identifier)
    {
        parent::__construct('Customer', $identifier, 'CUSTOMER_NOT_FOUND');
    }
}
```

### Interfaces

The available interfaces are:

* `Linio\Common\Exception\DoNotLog` - Tells Monolog to ignore the exception
* `Linio\Common\Exception\ForceLogging` - Tells Monolog to log the exception regardless of `DoNotLog`
* `Linio\Common\Exception\CriticalError` - Tells Monolog to log the exception as `CRITICAL` regardless of it's current level

## Logging (Monolog)

This component includes various classes that integrate with Monolog.

### Processors

* `Linio\Common\Logging\CriticalErrorProcessor` - Upgrades exceptions that are CriticalErrors to CRITICAL regardless of log level.
* `Linio\Common\Logging\ExceptionTokenProcessor` - Adds the exception token to the record.

### Handlers

#### DoNotLogHandler

* `Linio\Common\Logging\DoNotLogHandler` - Ignores exceptions that implement this interface.
