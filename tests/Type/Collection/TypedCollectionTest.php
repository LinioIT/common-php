<?php

declare(strict_types=1);

namespace Linio\Common\Type\Collection;

class TypedCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unsupported type: stdClass
     */
    public function testIsValidatingTypeOnConstruct()
    {
        $collection = $this->getMockForAbstractClass('Linio\Collection\TypedCollection');
        $collection->expects($this->at(0))
            ->method('isValidType')
            ->will($this->returnValue(true));
        $collection->expects($this->at(1))
            ->method('isValidType')
            ->will($this->returnValue(false));
        $collection->__construct([new \DateTime(), new \StdClass()]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unsupported type: string
     */
    public function testIsValidatingTypeOnOffsetSet()
    {
        $collection = $this->getMockForAbstractClass('Linio\Collection\TypedCollection');
        $collection->expects($this->once())
            ->method('isValidType')
            ->will($this->returnValue(false));
        $collection[] = 'foobar';
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unsupported type: string
     */
    public function testIsValidatingTypeOnAdd()
    {
        $collection = $this->getMockForAbstractClass('Linio\Collection\TypedCollection');
        $collection->expects($this->once())
            ->method('isValidType')
            ->will($this->returnValue(false));
        $collection->add('foobar');
    }
}
