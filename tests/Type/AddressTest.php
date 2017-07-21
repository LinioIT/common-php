<?php

declare(strict_types=1);

namespace Linio\Common\Type;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    public function testIsGettingFullAddress()
    {
        $address = new Address();
        $address->setLine1('foo');
        $address->setLine2('bar');
        $this->assertEquals('foo bar', $address->getFullAddress());
    }
}
