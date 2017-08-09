<?php

declare(strict_types=1);

namespace Linio\Common\Logging;

use Linio\Common\Exception\DomainException;
use PHPUnit\Framework\TestCase;

class ExceptionTokenProcessorTest extends TestCase
{
    public function testItAddsTheExceptionTokenToTheRecord(): void
    {
        $record = [
            'context' => [
                'exception' => new class('TOKEN') extends DomainException {
                },
            ],
        ];

        $processor = new ExceptionTokenProcessor();
        $actual = $processor($record);

        $this->assertSame('TOKEN', $actual['token']);
    }
}
