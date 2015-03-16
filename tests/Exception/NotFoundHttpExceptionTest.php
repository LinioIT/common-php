<?php

namespace Linio\Exception;

class NotFoundHttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasCorrectStatusCode()
    {
        $exception = new NotFoundHttpException('foobar', 42);
        $this->assertEquals(404, $exception->getStatusCode());
    }
}
