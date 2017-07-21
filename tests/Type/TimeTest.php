<?php

declare(strict_types=1);

namespace Linio\Common\Type;

use DateTime;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testIsCreatingTime(): void
    {
        $date = new Time('2014-01-22 09:09:09');
        $this->assertEquals('1970-01-01 09:09:09', $date->format('Y-m-d H:i:s'));
    }

    public function testIsCreatingFromDateTime(): void
    {
        $dateTime = new DateTime('2000-01-01 09:09:09');
        $time = Time::createFromDateTime($dateTime);

        $this->assertInstanceOf('Linio\Type\Time', $time);
        $this->assertEquals('09:09:09', $time->format('H:i:s'));
    }
}
