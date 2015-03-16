<?php

namespace Linio\Collection;

use Doctrine\Common\Collections\ArrayCollection;

abstract class TypedCollection extends ArrayCollection
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $elements = array())
    {
        foreach ($elements as $value) {
            $this->validateType($value);
        }

        parent::__construct($elements);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->validateType($value);
        parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function add($value)
    {
        $this->validateType($value);
        parent::add($value);
    }

    /**
     * @param mixed $value
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
     * @return boolean
     */
    abstract public function isValidType($value);
}
