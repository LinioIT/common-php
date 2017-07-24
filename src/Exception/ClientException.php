<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use Throwable;

class ClientException extends DomainException implements DoNotLog
{
    public const DEFAULT_STATUS_CODE = 400;

    public function __construct(
        string $token,
        string $message = ExceptionTokens::INVALID_REQUEST,
        int $statusCode = self::DEFAULT_STATUS_CODE,
        array $errors = [],
        Throwable $previous = null
    ) {
        parent::__construct($token, $message, $statusCode, $errors, $previous);
    }
}
