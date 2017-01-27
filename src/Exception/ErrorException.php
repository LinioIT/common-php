<?php

declare(strict_types=1);

namespace Linio\Exception;

use Psr\Log\LogLevel;

class ErrorException extends \RuntimeException
{
    /**
     * @return string
     */
    protected $logLevel;

    /**
     * @param string $message  Error message
     * @param int    $code     Internal code for the application error
     * @param string $logLevel Log level of the error, from Psr\Log\LogLevel
     */
    public function __construct(string $message, int $code, string $logLevel = LogLevel::ERROR)
    {
        $this->logLevel = $logLevel;
        parent::__construct($message, $code);
    }

    public function getLogLevel(): string
    {
        return $this->logLevel;
    }
}
