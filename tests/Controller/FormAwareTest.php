<?php

namespace Linio\Controller;

class FormAwareTest extends \PHPUnit_Framework_TestCase
{
    use FormAware;

    public function testIsGettingFormFactory()
    {
        $this->formFactory = $this->getMockBuilder('\Symfony\Component\Form\FormFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $actual = $this->getFormFactory();

        $this->assertInstanceOf('\Symfony\Component\Form\FormFactory', $actual);
    }

    public function testIsSettingFormFactory()
    {
        $mockFormFactory = $this->getMockBuilder('\Symfony\Component\Form\FormFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $this->setFormFactory($mockFormFactory);

        $this->assertInstanceOf('\Symfony\Component\Form\FormFactory', $this->formFactory);
    }

    public function testIsCreatingForm()
    {
        $mockForm = $this->getMockBuilder('\Symfony\Component\Form\Form')
            ->disableOriginalConstructor()
            ->getMock();

        $mockFormFactory = $this->getMockBuilder('\Symfony\Component\Form\FormFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $mockFormFactory->expects($this->once())
            ->method('create')
            ->with($this->equalTo('form_type'), $this->equalTo(['initial_data' => 'initial_data']), $this->equalTo(['options' => 'options']))
            ->will($this->returnValue($mockForm));

        $this->formFactory = $mockFormFactory;

        $actual = $this->createForm('form_type', ['initial_data' => 'initial_data'], ['options' => 'options']);

        $this->assertInstanceOf('\Symfony\Component\Form\Form', $actual);
    }

    public function testIsCreatingFormBuilder()
    {
        $mockFormBuilder = $this->getMockBuilder('\Symfony\Component\Form\FormBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $mockFormFactory = $this->getMockBuilder('\Symfony\Component\Form\FormFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $mockFormFactory
            ->expects($this->once())
            ->method('createBuilder')
            ->with($this->equalTo('form'), $this->equalTo(['initial_data' => 'initial_data']), $this->equalTo(['options' => 'options']))
            ->will($this->returnValue($mockFormBuilder));

        $this->formFactory = $mockFormFactory;

        $actual = $this->createFormBuilder(['initial_data' => 'initial_data'], ['options' => 'options']);

        $this->assertInstanceOf('\Symfony\Component\Form\FormBuilder', $actual);
    }
}
