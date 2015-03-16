<?php

namespace Linio\Type;

class Date extends \DateTime
{
	/**
	 * @param string $time
	 * @param \DateTimeZone $timezone
	 */
    public function __construct($time = 'now', \DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
        $this->setTime(0, 0, 0);
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return Date
     */
    public static function createFromDateTime(\DateTime $dateTime)
    {
    	return new self($dateTime->format('Y-m-d'));
    }
}
