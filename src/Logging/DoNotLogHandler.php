<?php

declare(strict_types=1);

namespace Linio\Common\Logging;

use Linio\Common\Exception\DoNotLog;
use Linio\Common\Exception\ForceLogging;
use Monolog\Handler\AbstractHandler;

class DoNotLogHandler extends AbstractHandler
{
    /**
     * Handles a record.
     *
     * All records may be passed to this method, and the handler should discard
     * those that it does not want to handle.
     *
     * The return value of this function controls the bubbling process of the handler stack.
     * Unless the bubbling is interrupted (by returning true), the Logger class will keep on
     * calling further handlers in the stack with a given log record.
     *
     * @param  array $record The record to handle
     *
     * @return bool true means that this handler handled the record, and that bubbling is not permitted.
     *                        false means the record was either not processed or that this handler allows bubbling.
     */
    public function handle(array $record)
    {
        $exception = $record['context']['exception'] ?? null;

        return $exception instanceof DoNotLog && !$exception instanceof ForceLogging;
    }
}
