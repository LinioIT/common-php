<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use Throwable;

class ClientException extends DomainException implements DoNotLog
{
    public const DEFAULT_STATUS_CODE = 400;

    public function __construct(
        string $token,
        int $statusCode = self::DEFAULT_STATUS_CODE,
        string $message = '',
        array $errors = [],
        Throwable $previous = null
    ) {
        parent::__construct($token, $statusCode, $message, $errors, $previous);
    }
}
