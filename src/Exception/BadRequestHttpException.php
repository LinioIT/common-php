<?php
declare(strict_types=1);

namespace Linio\Exception;

use Psr\Log\LogLevel;

class BadRequestHttpException extends HttpException
{
    /**
     * @param string $message  Error message
     * @param int    $code     Internal code for the application error
     * @param string $logLevel Log level of the error, from Psr\Log\LogLevel
     */
    public function __construct(string $message, int $code = 0, string $logLevel = LogLevel::WARNING)
    {
        parent::__construct($message, 400, $code, $logLevel);
    }
}
