<?php

declare(strict_types=1);

namespace Linio\Exception;

class MethodNotAllowedHttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasCorrectStatusCode()
    {
        $exception = new MethodNotAllowedHttpException('foobar');
        $this->assertEquals(405, $exception->getStatusCode());
    }
}
