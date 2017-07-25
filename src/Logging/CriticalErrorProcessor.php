<?php

declare(strict_types=1);

namespace Linio\Common\Logging;

use Linio\Common\Exception\CriticalError;

class CriticalErrorProcessor
{
    public function __invoke(array $record): array
    {
        $exception = $record['context']['exception'] ?? null;

        if (!$exception instanceof CriticalError) {
            return $record;
        }

        // Monolog doesn't use psr\log\LogLevel values internally
        $record['level'] = 500;
        $record['levelName'] = 'CRITICAL';

        return $record;
    }
}
