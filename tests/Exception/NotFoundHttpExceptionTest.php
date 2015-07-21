<?php

namespace Linio\Exception;

class NotFoundHttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasCorrectStatusCode()
    {
        $exception = new NotFoundHttpException('foobar');
        $this->assertEquals(404, $exception->getStatusCode());
    }
}
