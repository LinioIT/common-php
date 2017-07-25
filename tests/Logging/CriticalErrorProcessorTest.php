<?php

declare(strict_types=1);

namespace Linio\Common\Logging;

use Linio\Common\Exception\CriticalError;
use Linio\Common\Exception\DomainException;
use PHPUnit\Framework\TestCase;

class CriticalErrorProcessorTest extends TestCase
{
    public function testItUpgradesALogEntryToCritical(): void
    {
        $record = [
            'level' => 400,
            'levelName' => 'ERROR',
            'context' => [
                'exception' => new class('TOKEN') extends DomainException implements CriticalError {
                },
            ],
        ];

        $processor = new CriticalErrorProcessor();
        $actual = $processor($record);

        $this->assertSame(500, $actual['level']);
        $this->assertSame('CRITICAL', $actual['levelName']);
    }

    public function testItIgnoresNonCriticalErrors(): void
    {
        $record = [
            'level' => 400,
            'levelName' => 'ERROR',
        ];

        $processor = new CriticalErrorProcessor();
        $actual = $processor($record);

        $this->assertSame(400, $actual['level']);
        $this->assertSame('ERROR', $actual['levelName']);
    }
}
