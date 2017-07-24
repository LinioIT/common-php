<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use DomainException as SplDomainException;
use Throwable;

class DomainException extends SplDomainException
{
    public const DEFAULT_STATUS_CODE = 500;

    /**
     * @var string
     */
    private $token;

    /**
     * @var Error[]
     */
    private $errors = [];

    public function __construct(
        string $token,
        string $message = ExceptionTokens::AN_ERROR_HAS_OCCURRED,
        int $statusCode = self::DEFAULT_STATUS_CODE,
        array $errors = [],
        Throwable $previous = null
    ) {
        $this->token = $token;
        $this->errors = $errors;

        parent::__construct($message, $statusCode, $previous);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
