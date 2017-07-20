<?php

declare(strict_types=1);

namespace Linio\Exception;

class UnauthorizedHttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasCorrectStatusCode()
    {
        $exception = new UnauthorizedHttpException('foobar');
        $this->assertEquals(401, $exception->getStatusCode());
    }
}
