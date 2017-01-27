<?php

declare(strict_types=1);

namespace Linio\Exception;

use Psr\Log\LogLevel;

class HttpException extends ErrorException
{
    /**
     * @return int
     */
    protected $statusCode;

    /**
     * @return array
     */
    protected $headers;

    /**
     * @param string $message    Error message
     * @param int    $statusCode HTTP status code
     * @param int    $code       Internal code for the application error
     * @param string $logLevel   Log level of the error, from Psr\Log\LogLevel
     * @param array  $headers    Optional header response information
     */
    public function __construct(string $message, int $statusCode, int $code = 0, string $logLevel = LogLevel::WARNING, array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;

        parent::__construct($message, $code, $logLevel);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
