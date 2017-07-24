<?php

declare(strict_types=1);

namespace Linio\Common\Logging;

use Linio\Common\Exception\ClientException;
use Linio\Common\Exception\ForceLogging;
use PHPUnit\Framework\TestCase;

class DoNotLogHandlerTest extends TestCase
{
    public function testItSkipsRecordsWithNoExceptions()
    {
        $handler = new DoNotLogHandler();
        $actual = $handler->handle([]);

        $this->assertFalse($actual);
    }

    public function testItSkipsRecordsWithDoNotLog()
    {
        $exception = new ClientException('TEST');

        $handler = new DoNotLogHandler();
        $actual = $handler->handle(['context' => ['exception' => $exception]]);

        $this->assertTrue($actual);
    }

    public function testItDoesNotSkipRecordsWithForceLogging()
    {
        $exception = new class('TEST') extends ClientException implements ForceLogging {};

        $handler = new DoNotLogHandler();
        $actual = $handler->handle(['context' => ['exception' => $exception]]);

        $this->assertFalse($actual);
    }
}
