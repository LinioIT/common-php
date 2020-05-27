<?php

declare(strict_types=1);

namespace Linio\Common\Type;

class Money implements MoneyInterface
{
    /**
     * Money amount in cents.
     */
    protected int $amount = 0;

    /**
     * Number of digits after the decimal place.
     */
    protected int $scale = 2;

    public function __construct(float $amount = .0)
    {
        $this->amount = (int) round($amount * 100);
    }

    public static function fromCents(float $cents): MoneyInterface
    {
        $money = new static();
        $money->setAmount($cents);

        return $money;
    }

    public function add(MoneyInterface $operand): MoneyInterface
    {
        $result = $this->amount + $operand->getAmount();

        return static::fromCents($result);
    }

    public function subtract(MoneyInterface $operand): MoneyInterface
    {
        $result = $this->amount - $operand->getAmount();

        return static::fromCents($result);
    }

    public function multiply(float $multiplier): MoneyInterface
    {
        $result = $this->amount * $multiplier;

        return static::fromCents($result);
    }

    public function divide(float $divisor): MoneyInterface
    {
        $result = $this->amount / $divisor;

        return static::fromCents($result);
    }

    public function getPercentage(float $percentage): MoneyInterface
    {
        $percentage = $percentage / 100;
        $result = $this->amount * $percentage;

        return static::fromCents($result);
    }

    public function applyPercentage(float $percentage): MoneyInterface
    {
        $percentage = $this->getPercentage($percentage);

        return $this->add($percentage);
    }

    public function getInterest(float $rate, int $duration): MoneyInterface
    {
        $interest = $rate / 100;
        $result = ($this->amount * $duration) * $interest;

        return static::fromCents($result);
    }

    public function applyInterest(float $rate, int $duration): MoneyInterface
    {
        $interest = $this->getInterest($rate, $duration);

        return $this->add($interest);
    }

    public function equals(object $other): bool
    {
        if (!($other instanceof static)) {
            return false;
        }

        return $this->amount === $other->getAmount();
    }

    public function greaterThan(MoneyInterface $other): bool
    {
        return $this->amount >= $other->getAmount();
    }

    public function lessThan(MoneyInterface $other): bool
    {
        return $this->amount <= $other->getAmount();
    }

    public function isZero(): bool
    {
        return $this->amount == 0;
    }

    public function isPositive(): bool
    {
        return $this->amount > 0;
    }

    public function isNegative(): bool
    {
        return $this->amount < 0;
    }

    public function getMoneyAmount(): float
    {
        $money = $this->amount / 100;

        return round($money, $this->scale);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = (int) round($amount);
    }

    public function getScale(): int
    {
        return $this->scale;
    }

    public function setScale(int $scale): void
    {
        $this->scale = $scale;
    }

    public function __toString(): string
    {
        return (string) $this->amount;
    }
}
