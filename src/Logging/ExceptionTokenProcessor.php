<?php

declare(strict_types=1);

namespace Linio\Common\Logging;

use Linio\Common\Exception\DomainException;

class ExceptionTokenProcessor
{
    public function __invoke(array $record): array
    {
        $exception = $record['context']['exception'] ?? null;
        $token = null;

        if ($exception instanceof DomainException) {
            $token = $exception->getToken();
        }

        $record = ['token' => $token] + $record;

        return $record;
    }
}
