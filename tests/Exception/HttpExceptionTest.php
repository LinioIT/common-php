<?php

namespace Linio\Exception;

use Psr\Log\LogLevel;

class HttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testIsCreatingApiProblem()
    {
        $exception = new HttpException('foobar', 500, 42, LogLevel::WARNING, 'foobaz', ['Content-Type' => 'application/json']);
        $apiProblem = $exception->getApiProblem();
        $this->assertInstanceOf('Crell\ApiProblem\ApiProblem', $apiProblem);
        $this->assertEquals('foobar', $apiProblem->getTitle());
        $this->assertEquals('#42', $apiProblem->getType());
        $this->assertEquals('foobaz', $apiProblem->getDetail());
        $this->assertEquals(500, $apiProblem->getStatus());
        $this->assertEquals(LogLevel::WARNING, $exception->getLogLevel());
    }

    public function testIsCreatingHeaders()
    {
        $exception = new HttpException('foobar', 500, 42, LogLevel::WARNING, 'foobaz', ['Content-Type' => 'application/json']);
        $this->assertEquals(['Content-Type' => 'application/json'], $exception->getHeaders());
        $this->assertEquals(LogLevel::WARNING, $exception->getLogLevel());
    }
}
