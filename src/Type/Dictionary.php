<?php

declare(strict_types=1);

namespace Linio\Common\Type;

use Countable;
use JsonException;
use JsonSerializable;

class Dictionary implements JsonSerializable, Countable
{
    protected array $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if (!isset($this->data[$key])) {
            return $default;
        }

        return $this->data[$key];
    }

    /**
     * @param mixed $value
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    public function remove(string $key): void
    {
        unset($this->data[$key]);
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * @param mixed $value
     */
    public function contains($value): bool
    {
        return in_array($value, $this->data);
    }

    public function replace(array $data): void
    {
        $this->data = $data;
    }

    public function getKeys(): array
    {
        return array_keys($this->data);
    }

    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function clear(): void
    {
        $this->data = [];
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): string
    {
        $json = json_encode($this->data);

        if ($json === false) {
            throw new JsonException();
        }

        return $json;
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
