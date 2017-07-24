<?php

declare(strict_types=1);

namespace Linio\Common\Type\Collection;

use DateTime;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TypedCollectionTest extends TestCase
{
    public function testIsValidatingTypeOnConstruct(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported type: DateTime');

        new class([new DateTime(), new DateTimeImmutable()]) extends TypedCollection {
            public function isValidType($value): bool
            {
                return $value instanceof DateTimeImmutable;
            }
        };
    }

    public function testIsValidatingTypeOnOffsetSet(): void
    {
        $collection = new class([]) extends TypedCollection {
            public function isValidType($value): bool
            {
                return $value instanceof DateTimeImmutable;
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported type: DateTime');

        $collection[] = new DateTime();
    }

    public function testIsValidatingTypeOnAdd(): void
    {
        $collection = new class([]) extends TypedCollection {
            public function isValidType($value): bool
            {
                return $value instanceof DateTimeImmutable;
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported type: DateTime');

        $collection->add(new DateTime());
    }
}
