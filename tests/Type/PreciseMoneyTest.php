<?php

declare(strict_types=1);

namespace Linio\Type;

class PreciseMoneyTest extends \PHPUnit_Framework_TestCase
{
    public function testIsCreatingMoney()
    {
        $money = new PreciseMoney(200);
        $this->assertEquals(200, $money->getMoneyAmount());
        $this->assertEquals(20000, $money->getAmount());

        $money = new PreciseMoney(0);
        $money->setAmount(2456);
        $this->assertEquals(24.56, $money->getMoneyAmount());
        $this->assertEquals(2456, $money->getAmount());

        $money = new PreciseMoney(0);
        $money->setAmount(245656);
        $this->assertEquals(2456.56, $money->getMoneyAmount());
        $this->assertEquals(245656, $money->getAmount());

        $money = PreciseMoney::fromCents(245656);
        $this->assertEquals(2456.56, $money->getMoneyAmount());
        $this->assertEquals(245656, $money->getAmount());
    }

    public function testIsHandlingScale()
    {
        $money = new PreciseMoney(256.73);
        $money->setScale(3);
        $this->assertEquals(256.730, $money->getMoneyAmount());
        $this->assertEquals(3, $money->getScale());
    }

    public function testIsCreatingMoneyWithFloat()
    {
        $money = new PreciseMoney(25.00);
        $this->assertEquals(25, $money->getMoneyAmount());

        $money = new PreciseMoney(1.5);
        $this->assertEquals(1.5, $money->getMoneyAmount());

        $money = new PreciseMoney(18213.235);
        $this->assertEquals(18213.24, $money->getMoneyAmount());

        $money = new PreciseMoney(18213.2356);
        $this->assertEquals(18213.24, $money->getMoneyAmount());
    }

    /**
     * @expectedException \TypeError
     */
    public function testIsNotCreatingMoneyWithString()
    {
        $money = new PreciseMoney('test');
    }

    public function testIsAddingMonies()
    {
        $money1 = new PreciseMoney(100);
        $money2 = new PreciseMoney(100);
        $result = $money1->add($money2);
        $expected = new PreciseMoney(200);
        $this->assertEquals($expected->getMoneyAmount(), $result->getMoneyAmount());
    }

    public function testIsSubtractingMonies()
    {
        $money1 = new PreciseMoney(200);
        $money2 = new PreciseMoney(100);
        $result = $money1->subtract($money2);
        $expected = new PreciseMoney(100);
        $this->assertEquals($expected->getMoneyAmount(), $result->getMoneyAmount());

        $money1 = new PreciseMoney(400);
        $money2 = new PreciseMoney(600);
        $result = $money1->subtract($money2);
        $expected = new PreciseMoney(-200);
        $this->assertEquals($expected->getMoneyAmount(), $result->getMoneyAmount());
    }

    public function testIsMultiplyingMonies()
    {
        $money = new PreciseMoney(1);
        $expected = new PreciseMoney(2);
        $this->assertEquals($expected->getMoneyAmount(), $money->multiply(2)->getMoneyAmount());

        $money = new PreciseMoney(100);
        $expected = new PreciseMoney(300);
        $this->assertEquals($expected->getMoneyAmount(), $money->multiply(3)->getMoneyAmount());

        $money = new PreciseMoney(1);
        $expected = new PreciseMoney(1.5);
        $this->assertEquals($expected->getMoneyAmount(), $money->multiply(1.5)->getMoneyAmount());

        $money = new PreciseMoney(400);
        $result = $money->multiply(0.08)->multiply(15);
        $expected = new PreciseMoney(480);
        $this->assertEquals($expected->getMoneyAmount(), $result->getMoneyAmount());
    }

    public function testIsDividingMonies()
    {
        $money = new PreciseMoney(10);
        $expected = new PreciseMoney(5);
        $this->assertEquals($expected->getMoneyAmount(), $money->divide(2)->getMoneyAmount());

        $money = new PreciseMoney(10);
        $expected = new PreciseMoney(3.33);
        $this->assertEquals($expected->getMoneyAmount(), $money->divide(3)->getMoneyAmount());
    }

    public function testIsCalculatingPercentage()
    {
        $money = new PreciseMoney(100);
        $expected = new PreciseMoney(8);
        $this->assertEquals($expected->getAmount(), $money->getPercentage(8)->getAmount());
        $this->assertEquals($expected->getMoneyAmount(), $money->getPercentage(8)->getMoneyAmount());

        $money = new PreciseMoney(49.97);
        $expected = new PreciseMoney(3.94763);
        $total = new PreciseMoney(53.91763);
        $this->assertEquals($expected->getAmount(), $money->getPercentage(7.9)->getAmount());
        $this->assertEquals($expected->getMoneyAmount(), $money->getPercentage(7.9)->getMoneyAmount());
        $this->assertEquals($total->getAmount(), $money->applyPercentage(7.9)->getAmount());
        $this->assertEquals($total->getMoneyAmount(), $money->applyPercentage(7.9)->getMoneyAmount());

        $money = new PreciseMoney(556.68);
        $expected = new PreciseMoney(1.11336);
        $total = new PreciseMoney(557.79336);
        $this->assertEquals($expected->getAmount(), $money->getPercentage(0.2)->getAmount());
        $this->assertEquals($expected->getMoneyAmount(), $money->getPercentage(0.2)->getMoneyAmount());
        $this->assertEquals($total->getAmount(), $money->applyPercentage(0.2)->getAmount());
        $this->assertEquals($total->getMoneyAmount(), $money->applyPercentage(0.2)->getMoneyAmount());

        $money = new PreciseMoney(457.98);
        $expected = new PreciseMoney(0.01877718);
        $total = new PreciseMoney(457.99877718);
        $this->assertEquals($expected->getAmount(), $money->getPercentage(0.0041)->getAmount());
        $this->assertEquals($expected->getMoneyAmount(), $money->getPercentage(0.0041)->getMoneyAmount());
        $this->assertEquals($total->getAmount(), $money->applyPercentage(0.0041)->getAmount());
        $this->assertEquals($total->getMoneyAmount(), $money->applyPercentage(0.0041)->getMoneyAmount());
    }

    public function testIsCalculatingInterestRate()
    {
        $money = new PreciseMoney(100);
        $expected = new PreciseMoney(9.99);
        $total = new PreciseMoney(109.99);
        $this->assertEquals($expected->getAmount(), $money->getInterest(0.333, 30)->getAmount());
        $this->assertEquals($expected->getMoneyAmount(), $money->getInterest(0.333, 30)->getMoneyAmount());
        $this->assertEquals($total->getAmount(), $money->applyInterest(0.333, 30)->getAmount());
        $this->assertEquals($total->getMoneyAmount(), $money->applyInterest(0.333, 30)->getMoneyAmount());
    }

    public function testIsComparingMonies()
    {
        $money1 = new PreciseMoney(1);
        $money2 = new PreciseMoney(2);

        $this->assertTrue($money2->greaterThan($money1));
        $this->assertFalse($money1->greaterThan($money2));
        $this->assertTrue($money1->lessThan($money2));
        $this->assertFalse($money2->lessThan($money1));
        $this->assertTrue($money2->equals($money2));
        $this->assertFalse($money2->equals(new \stdClass()));
    }

    public function testIsCheckingMonies()
    {
        $this->assertTrue((new PreciseMoney(0))->isZero());
        $this->assertTrue((new PreciseMoney(-1))->isNegative());
        $this->assertTrue((new PreciseMoney(1))->isPositive());
        $this->assertFalse((new PreciseMoney(1))->isZero());
        $this->assertFalse((new PreciseMoney(1))->isNegative());
        $this->assertFalse((new PreciseMoney(-1))->isPositive());
    }

    public function testIsConvertingToString()
    {
        $money = new PreciseMoney(457.98);
        $this->assertEquals('45798', (string) $money);
        $this->assertEquals('45798', $money->__toString());
    }
}
