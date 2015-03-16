<?php

namespace Linio\Controller;

class TemplatingAwareTest extends \PHPUnit_Framework_TestCase
{
    use TemplatingAware;

    public function testIsGettingTemplating()
    {
        $this->templating = $this->getMockBuilder('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $actual = $this->getTemplating();

        $this->assertInstanceOf('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface', $actual);
    }

    public function testIsSettingTemplating()
    {
        $mockTemplating = $this->getMockBuilder('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->setTemplating($mockTemplating);

        $this->assertInstanceOf('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface', $this->templating);
    }

    public function testIsRenderingView()
    {
        $mockTemplating = $this->getMockBuilder('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockTemplating->expects($this->once())
            ->method('render')
            ->with($this->equalTo('route'), $this->equalTo(['parameters' => 'parameters']))
            ->will($this->returnValue('rendered_view'));

        $this->templating = $mockTemplating;

        $actual = $this->renderView('route', ['parameters' => 'parameters']);

        $this->assertEquals('rendered_view', $actual);
    }

    public function testIsRendering()
    {
        $mockResponse = $this->getMockBuilder('\Symfony\Component\HttpFoundation\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $mockTemplating = $this->getMockBuilder('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockTemplating->expects($this->once())
            ->method('renderResponse')
            ->with($this->equalTo('view'), $this->equalTo(['parameters' => 'parameters']), $this->equalTo($mockResponse))
            ->will($this->returnValue($mockResponse));

        $this->templating = $mockTemplating;

        $actual = $this->render('view', ['parameters' => 'parameters'], $mockResponse);

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $actual);
    }

    public function testIsStreaming()
    {
        $mockStreamedResponse = $this->getMockBuilder('\Symfony\Component\HttpFoundation\StreamedResponse')
            ->disableOriginalConstructor()
            ->getMock();

        $mockStreamedResponse->expects($this->once())
            ->method('setCallback')
            ->will($this->returnValue(true));

        $mockTemplating = $this->getMockBuilder('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->templating = $mockTemplating;

        $actual = $this->stream('view', ['parameters' => 'parameters'], $mockStreamedResponse);

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\StreamedResponse', $actual);
    }

    public function testIsStreamingWithNullResponseParameter()
    {
        $mockTemplating = $this->getMockBuilder('\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->templating = $mockTemplating;

        $actual = $this->stream('view', ['parameters' => 'parameters']);

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\StreamedResponse', $actual);
    }
}
