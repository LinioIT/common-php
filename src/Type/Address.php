<?php

declare(strict_types=1);

namespace Linio\Common\Type;

class Address
{
    protected ?string $line1 = null;
    protected ?string $line2 = null;
    protected ?string $postcode = null;
    protected ?string $city = null;
    protected ?string $state = null;
    protected ?string $country = null;

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): void
    {
        $this->line1 = $line1;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(string $line2): void
    {
        $this->line2 = $line2;
    }

    public function getFullAddress(): ?string
    {
        if (!$this->line1 && !$this->line2) {
            return null;
        }

        return $this->line1 . ' ' . $this->line2;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): void
    {
        $this->postcode = $postcode;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}
