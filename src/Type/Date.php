<?php

declare(strict_types=1);

namespace Linio\Type;

class Date extends \DateTime
{
    public function __construct(string $time = 'now', \DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
        $this->setTime(0, 0, 0);
    }

    public static function createFromDateTime(\DateTime $dateTime): Date
    {
        return new self($dateTime->format('Y-m-d'));
    }
}
