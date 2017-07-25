<?php

declare(strict_types=1);

namespace Linio\Common\Exception;

use PHPUnit\Framework\TestCase;

class EntityNotFoundExceptionTest extends TestCase
{
    public function testItSupportsMultipleIdentifiers()
    {
        $exception = new EntityNotFoundException('Postcode', [
            'region' => 'Region 1', 'municipality' => 'Municipality 1'
        ]);

        $this->assertSame(
            'Could not find [Postcode] identified by [region] = [Region 1], [municipality] = [Municipality 1]!',
            $exception->getMessage()
        );
    }
}
