<?php

namespace Linio\Collection;

class FixedTypedCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Index invalid or out of range
     */
    public function testIsValidatingSizeOnConstructor()
    {
        $collection = $this->getMockForAbstractClass('Linio\Collection\FixedTypedCollection', [], '', false);
        $collection->expects($this->at(0))
            ->method('isValidType')
            ->willReturn(true);
        $collection->expects($this->at(1))
            ->method('isValidType')
            ->willReturn(true);

        $collection->__construct(1, ['foo', 'bar']);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Index invalid or out of range
     */
    public function testIsValidatingSizeOnOffsetSet()
    {
        $collection = $this->getMockForAbstractClass('Linio\Collection\FixedTypedCollection', [], '', false);
        $collection->__construct(0);

        $collection[] = 'foo';
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Index invalid or out of range
     */
    public function testIsValidatingSizeOnAdd()
    {
        $collection = $this->getMockForAbstractClass('Linio\Collection\FixedTypedCollection', [], '', false);
        $collection->__construct(0);

        $collection->add('foo');
    }

    public function testIsGetting()
    {
        $collection = $this->getMockForAbstractClass('Linio\Collection\FixedTypedCollection', [], '', false);
        $collection->expects($this->at(0))
            ->method('isValidType')
            ->willReturn(true);

        $collection->__construct(1);
        $collection->add('foo');

        $this->assertEquals('foo', $collection->get(0));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Index invalid or out of range
     */
    public function testIsValidatingKeyOnGet()
    {
        $collection = $this->getMockForAbstractClass('Linio\Collection\FixedTypedCollection', [], '', false);
        $collection->__construct(1);

        $collection->get(2);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Index invalid or out of range
     */
    public function testIsValidatingKeyOnOffsetGet()
    {
        $collection = $this->getMockForAbstractClass('Linio\Collection\FixedTypedCollection', [], '', false);
        $collection->__construct(1);

        $collection[2];
    }

    public function testIsApplyingMatchingCriteria()
    {
        $criteria = $this->getMock(
            '\Doctrine\Common\Collections\Criteria',
            ['getWhereExpression', 'getFirstResult', 'getMaxResults']
        );

        $criteria->expects($this->once())
            ->method('getWhereExpression');

        $criteria->expects($this->once())
            ->method('getFirstResult');

        $criteria->expects($this->once())
            ->method('getMaxResults');

        $collection = $this->getMockForAbstractClass(
            'Linio\Collection\FixedTypedCollection',
            [1, ['1']],
            '',
            true,
            true,
            true,
            ['validateType']
        );

        $collection->matching($criteria);
    }
}
