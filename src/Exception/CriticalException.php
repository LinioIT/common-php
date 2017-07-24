<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

/*
 * This exception will be logged as a critical error in Monolog.
 */
class CriticalException extends DomainException
{
}
