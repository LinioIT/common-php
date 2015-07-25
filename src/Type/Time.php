<?php

namespace Linio\Type;

class Time extends \DateTime
{
    /**
     * @param string        $time
     * @param \DateTimeZone $timezone
     */
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
        $this->setDate(1970, 1, 1);
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return Time
     */
    public static function createFromDateTime(\DateTime $dateTime)
    {
        return new self($dateTime->format('H:i:s'));
    }
}
