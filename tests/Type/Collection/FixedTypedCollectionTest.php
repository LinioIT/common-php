<?php

declare(strict_types=1);

namespace Linio\Common\Type\Collection;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FixedTypedCollectionTest extends TestCase
{
    public function testIsValidatingSizeOnConstructor(): void
    {
        $object1 = new class() {
        };
        $object2 = new class() {
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Index invalid or out of range');

        new class(1, [$object1, $object2]) extends FixedTypedCollection {
            public function isValidType($value): bool
            {
                return true;
            }
        };
    }

    public function testIsValidatingSizeOnOffsetSet(): void
    {
        $collection = new class(0) extends FixedTypedCollection {
            public function isValidType($value): bool
            {
                return true;
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Index invalid or out of range');

        $collection[] = new class() {
        };
    }

    public function testIsValidatingSizeOnAdd(): void
    {
        $object1 = new class() {
        };

        $collection = new class(0) extends FixedTypedCollection {
            public function isValidType($value): bool
            {
                return true;
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Index invalid or out of range');

        $collection->add($object1);
    }

    public function testIsGetting(): void
    {
        $object1 = new class() {
        };

        $collection = new class(1, [$object1]) extends FixedTypedCollection {
            public function isValidType($value): bool
            {
                return true;
            }
        };

        $this->assertEquals($object1, $collection->get(0));
    }

    public function testIsValidatingKeyOnGet(): void
    {
        $object1 = new class() {
        };

        $collection = new class(1, [$object1]) extends FixedTypedCollection {
            public function isValidType($value): bool
            {
                return true;
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Index invalid or out of range');

        $collection->get(1);
    }

    public function testIsValidatingKeyOnOffsetGet(): void
    {
        $object1 = new class() {
            public $test = 'foo';
        };

        $collection = new class(1, [$object1]) extends FixedTypedCollection {
            public function isValidType($value): bool
            {
                return true;
            }
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Index invalid or out of range');

        $collection[2];
    }

    public function testIsApplyingMatchingCriteria(): void
    {
        $object1 = new class() {
            public $test = 'foo';
        };

        $collection = new class(1, [$object1]) extends FixedTypedCollection {
            public function isValidType($value): bool
            {
                return true;
            }
        };

        $criteria = Criteria::create()->where((new ExpressionBuilder())->eq('test', 'foo'));

        $actual = $collection->matching($criteria);

        $this->assertSame([$object1], $actual->getValues());
    }
}
