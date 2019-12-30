<?php

declare(strict_types=1);

namespace Linio\Common\Type;

interface MoneyInterface
{
    public static function fromCents(float $cents): MoneyInterface;

    public function add(MoneyInterface $operand): MoneyInterface;

    public function subtract(MoneyInterface $operand): MoneyInterface;

    public function multiply(float $multiplier): MoneyInterface;

    public function divide(float $divisor): MoneyInterface;

    public function getPercentage(float $percentage): MoneyInterface;

    public function applyPercentage(float $percentage): MoneyInterface;

    public function getInterest(float $rate, int $duration): MoneyInterface;

    public function applyInterest(float $rate, int $duration): MoneyInterface;

    public function equals(object $other): bool;

    public function greaterThan(MoneyInterface $other): bool;

    public function lessThan(MoneyInterface $other): bool;

    public function isZero(): bool;

    public function isPositive(): bool;

    public function isNegative(): bool;

    public function getMoneyAmount(): float;

    public function getAmount(): int;

    public function setAmount(float $amount): void;

    public function getScale(): int;

    public function setScale(int $scale): void;

    public function __toString(): string;
}
