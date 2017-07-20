<?php

declare(strict_types=1);

namespace Linio\Collection;

use Doctrine\Common\Collections\ArrayCollection;

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
    public function offsetSet($offset, $value)
    {
        $this->validateType($value);
        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function add($value)
    {
        $this->validateType($value);
        parent::add($value);
    }

    /**
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    protected function validateType($value)
    {
        if (!$this->isValidType($value)) {
            $type = is_object($value) ? get_class($value) : gettype($value);
            throw new \InvalidArgumentException('Unsupported type: ' . $type);
        }
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    abstract public function isValidType($value);
}
