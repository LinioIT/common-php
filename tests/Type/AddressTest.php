<?php

declare(strict_types=1);

namespace Linio\Common\Type;

use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testIsGettingFullAddress(): void
    {
        $address = new Address();
        $address->setLine1('foo');
        $address->setLine2('bar');
        $this->assertEquals('foo bar', $address->getFullAddress());
    }
}
