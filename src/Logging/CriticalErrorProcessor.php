<?php

declare(strict_types=1);

namespace Linio\Common\Logging;

use Linio\Common\Exception\CriticalError;
use Monolog\Logger;
use Psr\Log\LogLevel;

class CriticalErrorProcessor
{
    public function __invoke(array $record): array
    {
        $exception = $record['context']['exception'] ?? null;

        if (!$exception instanceof CriticalError) {
            return $record;
        }

        $record['level'] = Logger::toMonologLevel(LogLevel::CRITICAL);
        $record['levelName'] = Logger::getLevelName($record['level']);

        return $record;
    }
}
