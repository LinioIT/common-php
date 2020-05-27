<?php

declare(strict_types=1);

namespace Linio\Common\Type\Collection;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\ClosureExpressionVisitor;
use InvalidArgumentException;

abstract class FixedTypedCollection extends TypedCollection
{
    /**
     * @var int
     */
    protected $size;

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function __construct(int $size, array $elements = [])
    {
        $this->size = $size;

        parent::__construct($elements);

        if ($this->count() > $this->size) {
            throw new InvalidArgumentException('Index invalid or out of range');
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->validateSize();
        parent::offsetSet($offset, $value);
    }

    /**
     * @param int|string $key
     *
     * @throws InvalidArgumentException
     *
     * @return mixed|null
     */
    public function get($key)
    {
        if (!$this->containsKey($key)) {
            throw new InvalidArgumentException('Index invalid or out of range');
        }

        return parent::get($key);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $value
     */
    public function add($value): bool
    {
        $this->validateSize();

        return parent::add($value);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function validateSize(): void
    {
        if ($this->count() >= $this->size) {
            throw new InvalidArgumentException('Index invalid or out of range');
        }
    }

    /**
     * {@inheritdoc}
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
                $next = ClosureExpressionVisitor::sortByField((string) $field, $ordering == 'DESC' ? -1 : 1, $next);
            }

            if ($next) {
                usort($filtered, $next);
            }
        }

        $offset = $criteria->getFirstResult();
        $length = $criteria->getMaxResults();

        if ($offset || $length) {
            $filtered = array_slice($filtered, (int) $offset, $length);
        }

        return new static(count($filtered), $filtered);
    }
}
