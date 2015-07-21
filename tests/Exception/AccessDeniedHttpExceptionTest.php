<?php

namespace Linio\Exception;

class AccessDeniedHttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasCorrectStatusCode()
    {
        $exception = new AccessDeniedHttpException('foobar');
        $this->assertEquals(403, $exception->getStatusCode());
    }
}
