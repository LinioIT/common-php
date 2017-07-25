<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use DomainException as SplDomainException;
use Throwable;

class DomainException extends SplDomainException
{
    public const DEFAULT_STATUS_CODE = 500;

    /**
     * @var string|null
     */
    private $internalDetail;

    /**
     * @var Error[]
     */
    private $errors = [];

    public function __construct(
        string $token,
        int $statusCode = self::DEFAULT_STATUS_CODE,
        ?string $internalDetail = null,
        array $errors = [],
        Throwable $previous = null
    ) {
        $this->internalDetail = $internalDetail;
        $this->errors = $errors;

        parent::__construct($token, $statusCode, $previous);
    }

    public function getInternalDetail(): ?string
    {
        return $this->internalDetail;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
