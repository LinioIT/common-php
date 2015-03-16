<?php

namespace Linio\Exception;

class BadRequestHttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasCorrectStatusCode()
    {
        $exception = new BadRequestHttpException('foobar', 42);
        $this->assertEquals(400, $exception->getStatusCode());
    }
}
