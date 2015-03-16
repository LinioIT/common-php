<?php

namespace Linio\Type;

class Money
{
    /**
     * Money amount in cents
     *
     * @var int
     */
    protected $amount = 0;

    /**
     * Number of digits after the decimal place
     *
     * @var int
     */
    protected $scale = 2;

    /**
     * @param mixed $amount Money amount
     * @throws \InvalidArgumentException
     *
     * @return Money
     */
    public function __construct($amount = 0)
    {
        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException('Amount should be a numeric value');
        }

        $this->amount = $amount * 100;
    }

    /**
     * @param int $cents Money amount in cents
     * @throws InvalidArgumentException
     *
     * @return Money
     */
    public static function fromCents($cents)
    {
        if (!is_numeric($cents)) {
            throw new \InvalidArgumentException('Amount should be a numeric value');
        }

        $money = new Money();
        $money->setAmount($cents);

        return $money;
    }

    /**
     * @param Money $operand
     *
     * @return Money
     */
    public function add(Money $operand)
    {
        $result = $this->amount + $operand->getAmount();

        return Money::fromCents($result);
    }

    /**
     * @param Money $operand
     *
     * @return Money
     */
    public function subtract(Money $operand)
    {
        $result = $this->amount - $operand->getAmount();

        return Money::fromCents($result);
    }

    /**
     * @param float $multiplier
     *
     * @return Money
     */
    public function multiply($multiplier)
    {
        $result = $this->amount * $multiplier;

        return Money::fromCents($result);
    }

    /**
     * @param float $divisor
     *
     * @return Money
     */
    public function divide($divisor)
    {
        $result = $this->amount / $divisor;

        return Money::fromCents($result);
    }

    /**
     * @param float $percentage
     *
     * @return Money
     */
    public function getPercentage($percentage)
    {
        $percentage = $percentage / 100;
        $result = $this->amount * $percentage;

        return Money::fromCents($result);
    }

    /**
     * @param float $percentage
     *
     * @return Money
     */
    public function applyPercentage($percentage)
    {
        $percentage = $this->getPercentage($percentage);

        return $this->add($percentage);
    }

    /**
     * @param float $rate
     * @param int $duration
     * @return Money
     */
    public function getInterest($rate, $duration)
    {
        $interest = $rate / 100;
        $result = ($this->amount * $duration) * $interest;

        return Money::fromCents($result);
    }

    /**
     * @param float $rate
     * @param int $duration
     * @return Money
     */
    public function applyInterest($rate, $duration)
    {
        $interest = $this->getInterest($rate, $duration);

        return $this->add($interest);
    }

    /**
     * @param mixed $other
     * @return boolean
     */
    public function equals($other)
    {
        if (!($other instanceof Money)) {
            return false;
        }

        return $this->amount === $other->getAmount();
    }

    /**
     * @param Money $other
     * @return boolean
     */
    public function greaterThan(Money $other)
    {
        return $this->amount >= $other->getAmount();
    }

    /**
     * @param Money $other
     * @return boolean
     */
    public function lessThan(Money $other)
    {
        return $this->amount <= $other->getAmount();
    }

    /**
     * @return boolean
     */
    public function isZero()
    {
        return $this->amount == 0;
    }

    /**
     * @return boolean
     */
    public function isPositive()
    {
        return $this->amount > 0;
    }

    /**
     * @return boolean
     */
    public function isNegative()
    {
        return $this->amount < 0;
    }

    /**
     * @return float
     */
    public function getMoneyAmount()
    {
        $money = $this->amount / 100;

        return round($money, $this->scale);
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * @param int $scale
     */
    public function setScale($scale)
    {
        $this->scale = $scale;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->amount;
    }
}
