<?php

declare(strict_types=1);

namespace Linio\Common\Logging;

use Linio\Common\Exception\DomainException;

class ExceptionTokenProcessor
{
    public function __invoke(array $record): array
    {
        $exception = $record['context']['exception'] ?? null;

        if (!$exception instanceof DomainException) {
            return $record;
        }

        $record = ['token' => $exception->getToken()] + $record;

        return $record;
    }
}
