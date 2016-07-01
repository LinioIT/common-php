<?php
declare(strict_types=1);

namespace Linio\Type;

class Money
{
    /**
     * Money amount in cents.
     *
     * @var int
     */
    protected $amount = 0;

    /**
     * Number of digits after the decimal place.
     *
     * @var int
     */
    protected $scale = 2;

    public function __construct(float $amount = 0)
    {
        $this->amount = $amount * 100;
    }

    public static function fromCents(float $cents): Money
    {
        $money = new static();
        $money->setAmount($cents);

        return $money;
    }

    public function add(Money $operand): Money
    {
        $result = $this->amount + $operand->getAmount();

        return static::fromCents($result);
    }

    public function subtract(Money $operand): Money
    {
        $result = $this->amount - $operand->getAmount();

        return static::fromCents($result);
    }

    public function multiply(float $multiplier): Money
    {
        $result = $this->amount * $multiplier;

        return static::fromCents($result);
    }

    public function divide(float $divisor): Money
    {
        $result = $this->amount / $divisor;

        return static::fromCents($result);
    }

    public function getPercentage(float $percentage): Money
    {
        $percentage = $percentage / 100;
        $result = $this->amount * $percentage;

        return static::fromCents($result);
    }

    public function applyPercentage(float $percentage): Money
    {
        $percentage = $this->getPercentage($percentage);

        return $this->add($percentage);
    }

    public function getInterest(float $rate, int $duration): Money
    {
        $interest = $rate / 100;
        $result = ($this->amount * $duration) * $interest;

        return static::fromCents($result);
    }

    public function applyInterest(float $rate, int $duration): Money
    {
        $interest = $this->getInterest($rate, $duration);

        return $this->add($interest);
    }

    public function equals($other): bool
    {
        if (!($other instanceof static)) {
            return false;
        }

        return $this->amount === $other->getAmount();
    }

    public function greaterThan(Money $other): bool
    {
        return $this->amount >= $other->getAmount();
    }

    public function lessThan(Money $other): bool
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

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    public function getScale(): int
    {
        return $this->scale;
    }

    public function setScale(int $scale)
    {
        $this->scale = $scale;
    }

    public function __toString(): string
    {
        return (string) $this->amount;
    }
}
