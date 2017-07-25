<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use Throwable;

class EntityNotFoundException extends ClientException
{
    public const DEFAULT_STATUS_CODE = 404;

    public function __construct(
        string $message = '',
        string $token = ExceptionTokens::ENTITY_NOT_FOUND,
        int $statusCode = self::DEFAULT_STATUS_CODE,
        array $errors = [],
        Throwable $previous = null
    ) {
        parent::__construct($token, $statusCode, $message, $errors, $previous);
    }
}
