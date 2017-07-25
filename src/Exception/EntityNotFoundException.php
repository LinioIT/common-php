<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use Throwable;

class EntityNotFoundException extends ClientException
{
    public function __construct(
        string $token = ExceptionTokens::ENTITY_NOT_FOUND,
        int $statusCode = self::DEFAULT_STATUS_CODE,
        ?string $internalDetail = null,
        array $errors = [],
        Throwable $previous = null
    ) {
        parent::__construct($token, $statusCode, $internalDetail, $errors, $previous);
    }
}
