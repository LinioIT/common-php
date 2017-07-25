<?php

declare(strict_types=1);

namespace Linio\Common\Type;

use DateTime;
use DateTimeZone;

class Time extends DateTime
{
    public function __construct(string $time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
        $this->setDate(1970, 1, 1);
    }

    public static function createFromDateTime(DateTime $dateTime): Time
    {
        return new self($dateTime->format('H:i:s'));
    }
}
