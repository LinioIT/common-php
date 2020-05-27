<?php

declare(strict_types=1);

namespace Linio\Common\Type;

class PreciseMoney implements MoneyInterface
{
    public const CALCULATION_SCALE = 10;
    protected string $amount = '0';
    protected int $scale = 2;

    public function __construct(float $amount = .0)
    {
        $this->amount = bcmul((string) $amount, '100', static::CALCULATION_SCALE);
    }

    public static function fromCents(float $cents): MoneyInterface
    {
        $money = new static();
        $money->setAmount($cents);

        return $money;
    }

    public function add(MoneyInterface $operand): MoneyInterface
    {
        $result = bcadd($this->amount, (string) $operand->getAmount(), static::CALCULATION_SCALE);

        return static::fromCents((float) $result);
    }

    public function subtract(MoneyInterface $operand): MoneyInterface
    {
        $result = bcsub($this->amount, (string) $operand->getAmount(), static::CALCULATION_SCALE);

        return static::fromCents((float) $result);
    }

    public function multiply(float $multiplier): MoneyInterface
    {
        $result = bcmul($this->amount, (string) $multiplier, static::CALCULATION_SCALE);

        return static::fromCents((float) $result);
    }

    public function divide(float $divisor): MoneyInterface
    {
        $result = bcdiv($this->amount, (string) $divisor, static::CALCULATION_SCALE);

        return static::fromCents((float) $result);
    }

    public function getPercentage(float $percentage): MoneyInterface
    {
        $percentage = bcdiv((string) $percentage, '100', static::CALCULATION_SCALE);
        $result = bcmul($this->amount, (string) $percentage, static::CALCULATION_SCALE);

        return static::fromCents((float) $result);
    }

    public function applyPercentage(float $percentage): MoneyInterface
    {
        $percentage = $this->getPercentage($percentage);

        return $this->add($percentage);
    }

    public function getInterest(float $rate, int $duration): MoneyInterface
    {
        $interest = bcdiv((string) $rate, '100', static::CALCULATION_SCALE);
        $result = bcmul(
            bcmul(
                $this->amount,
                (string) $duration,
                static::CALCULATION_SCALE
            ),
            (string) $interest,
            static::CALCULATION_SCALE
        );

        return static::fromCents((float) $result);
    }

    public function applyInterest(float $rate, int $duration): MoneyInterface
    {
        $interest = $this->getInterest($rate, $duration);

        return $this->add($interest);
    }

    public function equals(object $other): bool
    {
        if (!($other instanceof MoneyInterface)) {
            return false;
        }

        return bccomp($this->amount, (string) $other->getAmount()) === 0;
    }

    public function greaterThan(MoneyInterface $other): bool
    {
        return bccomp($this->amount, (string) $other->getAmount()) === 1;
    }

    public function lessThan(MoneyInterface $other): bool
    {
        return bccomp($this->amount, (string) $other->getAmount()) === -1;
    }

    public function isZero(): bool
    {
        return bccomp($this->amount, '0') === 0;
    }

    public function isPositive(): bool
    {
        return bccomp($this->amount, '0') === 1;
    }

    public function isNegative(): bool
    {
        return bccomp($this->amount, '0') === -1;
    }

    public function getMoneyAmount(): float
    {
        $money = bcdiv($this->amount, '100', static::CALCULATION_SCALE);

        return round((float) $money, $this->scale);
    }

    public function getAmount(): int
    {
        return (int) round((float) $this->amount);
    }

    public function setAmount(float $amount): void
    {
        $this->amount = (string) $amount;
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
        return (string) $this->getAmount();
    }
}
