<?php

declare(strict_types=1);

namespace Linio\Type;

class Dictionary implements \JsonSerializable, \Countable
{
    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function get(string $key, $default = null)
    {
        if (!isset($this->data[$key])) {
            return $default;
        }

        return $this->data[$key];
    }

    public function set(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    public function remove(string $key)
    {
        unset($this->data[$key]);
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function contains($value): bool
    {
        return in_array($value, $this->data);
    }

    public function replace(array $data)
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

    public function clear()
    {
        $this->data = [];
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): string
    {
        return json_encode($this->data);
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
