<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DomainExceptionTest extends TestCase
{
    public function testItDoesNotAllowTokensThatAreNotUpperSnakeCase(): void
    {
        try {
            throw new DomainException('invalid');
        } catch (InvalidArgumentException $exception) {
            $this->assertSame(ExceptionTokens::INVALID_EXCEPTION_TOKEN, $exception->getMessage());
            $this->assertSame(500, $exception->getCode());
        }
    }

    public function testItDoesNotAllowTokensThatAreASingleLetter(): void
    {
        try {
            throw new DomainException('A');
        } catch (InvalidArgumentException $exception) {
            $this->assertSame(ExceptionTokens::INVALID_EXCEPTION_TOKEN, $exception->getMessage());
            $this->assertSame(500, $exception->getCode());
        }
    }

    public function testItDoesNotAllowTokensThatEndInAnUnderscore(): void
    {
        try {
            throw new DomainException('A_');
        } catch (InvalidArgumentException $exception) {
            $this->assertSame(ExceptionTokens::INVALID_EXCEPTION_TOKEN, $exception->getMessage());
            $this->assertSame(500, $exception->getCode());
        }
    }
}
