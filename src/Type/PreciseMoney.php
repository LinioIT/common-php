<?php

declare(strict_types=1);

namespace Linio\Common\Type;

class PreciseMoney extends Money
{
    const CALCULATION_SCALE = 10;

    public function __construct(float $amount = 0)
    {
        $this->amount = bcmul((string) $amount, '100', self::CALCULATION_SCALE);
    }

    public function add(Money $operand): Money
    {
        $result = bcadd($this->amount, (string) $operand->getAmount(), self::CALCULATION_SCALE);

        return Money::fromCents((float) $result);
    }

    public function subtract(Money $operand): Money
    {
        $result = bcsub($this->amount, (string) $operand->getAmount(), self::CALCULATION_SCALE);

        return Money::fromCents((float) $result);
    }

    public function multiply(float $multiplier): Money
    {
        $result = bcmul($this->amount, (string) $multiplier, self::CALCULATION_SCALE);

        return Money::fromCents((float) $result);
    }

    public function divide(float $divisor): Money
    {
        $result = bcdiv($this->amount, (string) $divisor, self::CALCULATION_SCALE);

        return Money::fromCents((float) $result);
    }

    public function getPercentage(float $percentage): Money
    {
        $percentage = bcdiv((string) $percentage, '100', self::CALCULATION_SCALE);
        $result = bcmul($this->amount, (string) $percentage, self::CALCULATION_SCALE);

        return Money::fromCents((float) $result);
    }

    public function applyPercentage(float $percentage): Money
    {
        $percentage = $this->getPercentage($percentage);

        return $this->add($percentage);
    }

    public function getInterest(float $rate, int $duration): Money
    {
        $interest = bcdiv((string) $rate, '100', self::CALCULATION_SCALE);
        $result = bcmul(
            bcmul(
                $this->amount,
                (string) $duration,
                self::CALCULATION_SCALE
            ),
            (string) $interest,
            self::CALCULATION_SCALE
        );

        return Money::fromCents((float) $result);
    }

    public function applyInterest(float $rate, int $duration): Money
    {
        $interest = $this->getInterest($rate, $duration);

        return $this->add($interest);
    }

    public function equals($other): bool
    {
        if (!($other instanceof Money)) {
            return false;
        }

        return bccomp((string) $this->amount, (string) $other->getAmount()) === 0;
    }

    public function greaterThan(Money $other): bool
    {
        return bccomp((string) $this->amount, (string) $other->getAmount()) === 1;
    }

    public function lessThan(Money $other): bool
    {
        return bccomp((string) $this->amount, (string) $other->getAmount()) === -1;
    }

    public function getMoneyAmount(): float
    {
        $money = bcdiv($this->amount, '100', self::CALCULATION_SCALE);

        return round($money, $this->scale);
    }

    public function getAmount(): int
    {
        return (int) round($this->amount);
    }

    public function setAmount(float $amount): void
    {
        $this->amount = (string) $amount;
    }

    public function __toString(): string
    {
        return (string) $this->getAmount();
    }
}
