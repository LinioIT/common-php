<?php

namespace Linio\Type;

class PreciseMoney extends Money
{
    const CALCULATION_SCALE = 10;

    /**
     * @param mixed $amount
     *
     * @return Money
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($amount = 0)
    {
        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException('Amount should be a numeric value');
        }

        $this->amount = bcmul($amount, 100, self::CALCULATION_SCALE);
    }

    /**
     * @param Money $operand
     *
     * @return Money
     */
    public function add(Money $operand)
    {
        $result = bcadd($this->amount, $operand->getAmount(), self::CALCULATION_SCALE);

        return Money::fromCents($result);
    }

    /**
     * @param Money $operand
     *
     * @return Money
     */
    public function subtract(Money $operand)
    {
        $result = bcsub($this->amount, $operand->getAmount(), self::CALCULATION_SCALE);

        return Money::fromCents($result);
    }

    /**
     * @param float $multiplier
     *
     * @return Money
     */
    public function multiply($multiplier)
    {
        $result = bcmul($this->amount, $multiplier, self::CALCULATION_SCALE);

        return Money::fromCents($result);
    }

    /**
     * @param float $divisor
     *
     * @return Money
     */
    public function divide($divisor)
    {
        $result = bcdiv($this->amount, $divisor, self::CALCULATION_SCALE);

        return Money::fromCents($result);
    }

    /**
     * @param float $percentage
     *
     * @return Money
     */
    public function getPercentage($percentage)
    {
        $percentage = bcdiv($percentage, 100, self::CALCULATION_SCALE);
        $result = bcmul($this->amount, $percentage, self::CALCULATION_SCALE);

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
     * @param int   $duration
     *
     * @return Money
     */
    public function getInterest($rate, $duration)
    {
        $interest = bcdiv($rate, 100, self::CALCULATION_SCALE);
        $result = bcmul(
            bcmul(
                $this->amount,
                $duration,
                self::CALCULATION_SCALE
            ),
            $interest,
            self::CALCULATION_SCALE
        );

        return Money::fromCents($result);
    }

    /**
     * @param float $rate
     * @param int   $duration
     *
     * @return Money
     */
    public function applyInterest($rate, $duration)
    {
        $interest = $this->getInterest($rate, $duration);

        return $this->add($interest);
    }

    /**
     * @param mixed $other Object
     *
     * @return bool
     */
    public function equals($other)
    {
        if (!($other instanceof Money)) {
            return false;
        }

        return (bccomp($this->amount, $other->getAmount()) === 0);
    }

    /**
     * @param Money $other
     *
     * @return bool
     */
    public function greaterThan(Money $other)
    {
        return (bccomp($this->amount, $other->getAmount()) === 1);
    }

    /**
     * @param Money $other
     *
     * @return bool
     */
    public function lessThan(Money $other)
    {
        return (bccomp($this->amount, $other->getAmount()) === -1);
    }

    /**
     * @return float
     */
    public function getMoneyAmount()
    {
        $money = bcdiv($this->amount, 100, self::CALCULATION_SCALE);

        return round($money, $this->scale);
    }
}
