# Linio Common
[![Latest Stable Version](https://poser.pugx.org/linio/common/v/stable.svg)](https://packagist.org/packages/linio/common) [![License](https://poser.pugx.org/linio/common/license.svg)](https://packagist.org/packages/linio/common) [![Build Status](https://secure.travis-ci.org/LinioIT/common.png)](http://travis-ci.org/LinioIT/common) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/LinioIT/common/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/LinioIT/common/?branch=master)

Linio Common contains small components that either extend PHP's functionality or provide
a coherent base for Linio components:

* Common types
* Base exceptions
* Monolog processors and handlers

## Install

### PHP requirements

Supported PHP branches and minimum patch versions are:

| PHP branch | Minimum version |
| --- | --- |
| 8.2 | 8.2.35 |
| 8.3 | 8.3.36 |
| 8.4 | 8.4.27 |
| 8.5 | 8.5.12 |

Later patch releases within these branches are supported and recommended. PHP 8.1
and older, earlier patches, and unlisted branches are not supported.

These minimum versions contain the fixes for CVE-2026-109618 and CVE-2026-109619
described in the [PHP security advisory of October 21, 2026](https://www.php.net/archive/2026.php#2026-10-21-5).
The vulnerabilities are in the PHP runtime, not in this library. Updating this
package alone does not patch PHP: update the interpreter used by every deployment,
including PHP-FPM, Apache, CGI, FrankenPHP, LiteSpeed, CLI and CI, and restart all
web workers after the update. Verify the PHP version used by the web server
separately from `php -v`, which only checks the CLI runtime.

Composer rejects versions outside the supported ranges, but it cannot update the
runtime or protect deployments that bypass platform checks. Do not use
`--ignore-platform-reqs` or a `config.platform.php` override to simulate a patched
runtime. Run `composer check-platform-reqs --no-dev` on the deployed environment
and verify the web runtime separately. Configuration workarounds are not a
complete fix and are not applied by this library.

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
