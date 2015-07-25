<?php

namespace Linio\Collection;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\ClosureExpressionVisitor;

abstract class FixedTypedCollection extends TypedCollection
{
    /**
     * @var int
     */
    protected $size;

    /**
     * @param int   $size
     * @param array $elements
     */
    public function __construct($size, array $elements = [])
    {
        $this->size = (int) $size;

        parent::__construct($elements);

        if ($this->count() > $this->size) {
            throw new \InvalidArgumentException('Index invalid or out of range');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->validateSize();
        parent::offsetSet($offset, $value);
    }

    /**
     * @param int|string $key
     *
     * @return mixed|null
     *
     * @throws \InvalidArgumentException
     */
    public function get($key)
    {
        if (!$this->containsKey($key)) {
            throw new \InvalidArgumentException('Index invalid or out of range');
        }

        return parent::get($key);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function add($value)
    {
        $this->validateSize();
        parent::add($value);
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function validateSize()
    {
        if ($this->count() >= $this->size) {
            throw new \InvalidArgumentException('Index invalid or out of range');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function matching(Criteria $criteria)
    {
        $expr = $criteria->getWhereExpression();
        $filtered = $this->toArray();

        if ($expr) {
            $visitor = new ClosureExpressionVisitor();
            $filter = $visitor->dispatch($expr);
            $filtered = array_filter($filtered, $filter);
        }

        if ($orderings = $criteria->getOrderings()) {
            $next = null;
            foreach (array_reverse($orderings) as $field => $ordering) {
                $next = ClosureExpressionVisitor::sortByField($field, $ordering == 'DESC' ? -1 : 1, $next);
            }

            usort($filtered, $next);
        }

        $offset = $criteria->getFirstResult();
        $length = $criteria->getMaxResults();

        if ($offset || $length) {
            $filtered = array_slice($filtered, (int) $offset, $length);
        }

        return new static(count($filtered), $filtered);
    }
}
