<?php

declare(strict_types=1);

namespace Linio\Common\Type\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;

abstract class TypedCollection extends ArrayCollection
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $elements = [])
    {
        foreach ($elements as $value) {
            $this->validateType($value);
        }

        parent::__construct($elements);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
        $this->validateType($value);
        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function add($value): void
    {
        $this->validateType($value);
        parent::add($value);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function validateType($value): void
    {
        if (!$this->isValidType($value)) {
            $type = is_object($value) ? get_class($value) : gettype($value);
            throw new InvalidArgumentException('Unsupported type: ' . $type);
        }
    }

    abstract public function isValidType($value): bool;
}
