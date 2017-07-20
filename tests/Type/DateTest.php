<?php

declare(strict_types=1);

namespace Linio\Type;

class DateTest extends \PHPUnit_Framework_TestCase
{
    public function testIsCreatingDate()
    {
        $date = new Date('2000-01-01 09:09:09');
        $this->assertEquals('2000-01-01 00:00:00', $date->format('Y-m-d H:i:s'));
    }

    public function testIsCreatingFromDateTime()
    {
        $dateTime = new \DateTime('2000-01-01 09:09:09');
        $date = Date::createFromDateTime($dateTime);

        $this->assertInstanceOf('Linio\Type\Date', $date);
        $this->assertEquals('2000-01-01', $date->format('Y-m-d'));
    }
}
