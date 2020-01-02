<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

class Error
{
    protected string $message;
    protected ?string $field = null;

    /**
     * @param string $message any text string is valid, however, TOKENS are recommended to support translation
     */
    public function __construct(string $message, ?string $field = null)
    {
        $this->field = $field;
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getField(): ?string
    {
        return $this->field;
    }
}
