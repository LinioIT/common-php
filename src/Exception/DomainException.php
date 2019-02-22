<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use DomainException as SplDomainException;
use InvalidArgumentException;
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
        int $statusCode = self::DEFAULT_STATUS_CODE,
        string $message = ExceptionTokens::AN_ERROR_HAS_OCCURRED,
        array $errors = [],
        Throwable $previous = null
    ) {
        if (!$this->isExceptionToken($token)) {
            throw new InvalidArgumentException(ExceptionTokens::INVALID_EXCEPTION_TOKEN, 500);
        }

        $this->token = $token;
        $this->errors = $errors;

        parent::__construct($message, $statusCode, $previous);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    private function isExceptionToken(string $token): bool
    {
        return preg_match('/^[A-Z][A-Z_]*[A-Z]$/', $token) === 1;
    }
}
