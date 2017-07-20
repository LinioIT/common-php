<?php

declare(strict_types=1);

namespace Linio\Exception;

class ForbiddenHttpExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasCorrectStatusCode()
    {
        $exception = new ForbiddenHttpException('foobar');
        $this->assertEquals(403, $exception->getStatusCode());
    }
}
