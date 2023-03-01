<?php

declare(strict_types=1);

namespace Linio\Common\Type;

use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;

class MoneyChild extends Money
{
    // stub
}

class MoneyTest extends TestCase
{
    public function testIsCreatingMoney(): void
    {
        $money = new Money(200);
        $this->assertEquals(200, $money->getMoneyAmount());
        $this->assertEquals(20000, $money->getAmount());

        $money = new Money(0);
        $money->setAmount(2456);
        $this->assertEquals(24.56, $money->getMoneyAmount());
        $this->assertEquals(2456, $money->getAmount());

        $money = new Money(0);
        $money->setAmount(245656);
        $this->assertEquals(2456.56, $money->getMoneyAmount());
        $this->assertEquals(245656, $money->getAmount());

        $money = Money::fromCents(245656);
        $this->assertEquals(2456.56, $money->getMoneyAmount());
        $this->assertEquals(245656, $money->getAmount());
    }

    public function testIsHandlingScale(): void
    {
        $money = new Money(256.73);
        $money->setScale(3);
        $this->assertEquals(256.730, $money->getMoneyAmount());
        $this->assertEquals(3, $money->getScale());
    }

    public function testIsCreatingMoneyWithFloat(): void
    {
        $money = new Money(25.00);
        $this->assertEquals(25, $money->getMoneyAmount());

        $money = new Money(1.5);
        $this->assertEquals(1.5, $money->getMoneyAmount());

        $money = new Money(18213.235);
        $this->assertEquals(18213.24, $money->getMoneyAmount());

        $money = new Money(18213.2356);
        $this->assertEquals(18213.24, $money->getMoneyAmount());
    }

    public function testIsNotCreatingMoneyWithString(): void
    {
        $this->expectException(TypeError::class);
        new Money('test');
    }

    public function testIsAddingMonies(): void
    {
        $money1 = new Money(100);
        $money2 = new Money(100);
        $result = $money1->add($money2);
        $expected = new Money(200);
        $this->assertEquals($expected->getMoneyAmount(), $result->getMoneyAmount());
    }

    public function testIsSubtractingMonies(): void
    {
        $money1 = new Money(200);
        $money2 = new Money(100);
        $result = $money1->subtract($money2);
        $expected = new Money(100);
        $this->assertEquals($expected->getMoneyAmount(), $result->getMoneyAmount());

        $money1 = new Money(400);
        $money2 = new Money(600);
        $result = $money1->subtract($money2);
        $expected = new Money(-200);
        $this->assertEquals($expected->getMoneyAmount(), $result->getMoneyAmount());
    }

    public function testIsMultiplyingMonies(): void
    {
        $money = new Money(1);
        $expected = new Money(2);
        $this->assertEquals($expected->getMoneyAmount(), $money->multiply(2)->getMoneyAmount());

        $money = new Money(100);
        $expected = new Money(300);
        $this->assertEquals($expected->getMoneyAmount(), $money->multiply(3)->getMoneyAmount());

        $money = new Money(1);
        $expected = new Money(1.5);
        $this->assertEquals($expected->getMoneyAmount(), $money->multiply(1.5)->getMoneyAmount());

        $money = new Money(400);
        $result = $money->multiply(0.08)->multiply(15);
        $expected = new Money(480);
        $this->assertEquals($expected->getMoneyAmount(), $result->getMoneyAmount());
    }

    public function testIsDividingMonies(): void
    {
        $money = new Money(10);
        $expected = new Money(5);
        $this->assertEquals($expected->getMoneyAmount(), $money->divide(2)->getMoneyAmount());

        $money = new Money(10);
        $expected = new Money(3.33);
        $this->assertEquals($expected->getMoneyAmount(), $money->divide(3)->getMoneyAmount());
    }

    public function testIsCalculatingPercentage(): void
    {
        $money = new Money(100);
        $expected = new Money(8);
        $this->assertEquals($expected->getAmount(), $money->getPercentage(8)->getAmount());
        $this->assertEquals($expected->getMoneyAmount(), $money->getPercentage(8)->getMoneyAmount());

        $money = new Money(49.97);
        $expected = new Money(3.94763);
        $total = new Money(53.91763);
        $this->assertEquals($expected->getAmount(), $money->getPercentage(7.9)->getAmount());
        $this->assertEquals($expected->getMoneyAmount(), $money->getPercentage(7.9)->getMoneyAmount());
        $this->assertEquals($total->getAmount(), $money->applyPercentage(7.9)->getAmount());
        $this->assertEquals($total->getMoneyAmount(), $money->applyPercentage(7.9)->getMoneyAmount());

        $money = new Money(556.68);
        $expected = new Money(1.11336);
        $total = new Money(557.79336);
        $this->assertEquals($expected->getAmount(), $money->getPercentage(0.2)->getAmount());
        $this->assertEquals($expected->getMoneyAmount(), $money->getPercentage(0.2)->getMoneyAmount());
        $this->assertEquals($total->getAmount(), $money->applyPercentage(0.2)->getAmount());
        $this->assertEquals($total->getMoneyAmount(), $money->applyPercentage(0.2)->getMoneyAmount());

        $money = new Money(457.98);
        $expected = new Money(0.01877718);
        $total = new Money(457.99877718);
        $this->assertEquals($expected->getAmount(), $money->getPercentage(0.0041)->getAmount());
        $this->assertEquals($expected->getMoneyAmount(), $money->getPercentage(0.0041)->getMoneyAmount());
        $this->assertEquals($total->getAmount(), $money->applyPercentage(0.0041)->getAmount());
        $this->assertEquals($total->getMoneyAmount(), $money->applyPercentage(0.0041)->getMoneyAmount());
    }

    public function testIsCalculatingInterestRate(): void
    {
        $money = new Money(100);
        $expected = new Money(9.99);
        $total = new Money(109.99);
        $this->assertEquals($expected->getAmount(), $money->getInterest(0.333, 30)->getAmount());
        $this->assertEquals($expected->getMoneyAmount(), $money->getInterest(0.333, 30)->getMoneyAmount());
        $this->assertEquals($total->getAmount(), $money->applyInterest(0.333, 30)->getAmount());
        $this->assertEquals($total->getMoneyAmount(), $money->applyInterest(0.333, 30)->getMoneyAmount());
    }

    public function testIsComparingMonies(): void
    {
        $money1 = new Money(1);
        $money2 = new Money(2);

        $this->assertTrue($money2->greaterThan($money1));
        $this->assertFalse($money1->greaterThan($money2));
        $this->assertTrue($money1->lessThan($money2));
        $this->assertFalse($money2->lessThan($money1));
        $this->assertTrue($money2->equals($money2));
        $this->assertFalse($money2->equals(new stdClass()));
    }

    public function testIsCheckingMonies(): void
    {
        $this->assertTrue((new Money(0))->isZero());
        $this->assertTrue((new Money(-1))->isNegative());
        $this->assertTrue((new Money(1))->isPositive());
        $this->assertFalse((new Money(1))->isZero());
        $this->assertFalse((new Money(1))->isNegative());
        $this->assertFalse((new Money(-1))->isPositive());
    }

    public function testIsConvertingToString(): void
    {
        $money = new Money(457.98);
        $this->assertEquals('45798', (string) $money);
        $this->assertEquals('45798', $money->__toString());
    }

    public function testIsCreatingMoneySubclasses(): void
    {
        $child = MoneyChild::fromCents(1000);
        $this->assertInstanceOf(MoneyChild::class, $child);
    }
}
