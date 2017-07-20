<?php

declare(strict_types=1);

namespace Linio\Controller;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Test\FormBuilderInterface;

class FormAwareTest extends \PHPUnit_Framework_TestCase
{
    use FormAware;

    public function testIsGettingFormFactory()
    {
        $this->formFactory = $this->getMockBuilder(FormFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $actual = $this->getFormFactory();

        $this->assertInstanceOf(FormFactory::class, $actual);
    }

    public function testIsSettingFormFactory()
    {
        $mockFormFactory = $this->getMockBuilder(FormFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->setFormFactory($mockFormFactory);

        $this->assertInstanceOf(FormFactory::class, $this->formFactory);
    }

    public function testIsCreatingForm()
    {
        $mockForm = $this->getMockBuilder(Form::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockFormFactory = $this->getMockBuilder(FormFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockFormFactory->expects($this->once())
            ->method('create')
            ->with($this->equalTo(FormType::class), $this->equalTo(['initial_data' => 'initial_data']), $this->equalTo(['options' => 'options']))
            ->will($this->returnValue($mockForm));

        $this->formFactory = $mockFormFactory;

        $actual = $this->createForm(FormType::class, ['initial_data' => 'initial_data'], ['options' => 'options']);

        $this->assertInstanceOf(Form::class, $actual);
    }

    public function testIsCreatingFormBuilder()
    {
        $mockFormBuilder = $this->getMockBuilder(FormBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockFormFactory = $this->getMockBuilder(FormFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockFormFactory
            ->expects($this->once())
            ->method('createBuilder')
            ->with($this->equalTo(FormType::class), $this->equalTo(['initial_data' => 'initial_data']), $this->equalTo(['options' => 'options']))
            ->will($this->returnValue($mockFormBuilder));

        $this->formFactory = $mockFormFactory;

        $actual = $this->createFormBuilder(['initial_data' => 'initial_data'], ['options' => 'options']);

        $this->assertInstanceOf(FormBuilderInterface::class, $actual);
    }
}
