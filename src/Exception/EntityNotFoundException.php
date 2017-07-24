<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use Throwable;

class EntityNotFoundException extends ClientException
{
    public function __construct(
        string $token = ExceptionTokens::ENTITY_NOT_FOUND,
        string $message = ExceptionTokens::ENTITY_NOT_FOUND,
        int $statusCode = self::DEFAULT_STATUS_CODE,
        array $errors = [],
        Throwable $previous = null
    ) {
        parent::__construct($token, $message, $statusCode, $errors, $previous);
    }
}
