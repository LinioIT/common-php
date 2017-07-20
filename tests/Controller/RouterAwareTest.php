<?php

declare(strict_types=1);

namespace Linio\Controller;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RouterAwareTest extends \PHPUnit_Framework_TestCase
{
    use RouterAware;

    public function testIsGettingRouter()
    {
        $this->router = $this->getMockBuilder('\Symfony\Component\Routing\RouterInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $actual = $this->getRouter();

        $this->assertInstanceOf('\Symfony\Component\Routing\RouterInterface', $actual);
    }

    public function testIsSettingRouter()
    {
        $mockRouterInterface = $this->getMockBuilder('\Symfony\Component\Routing\RouterInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->setRouter($mockRouterInterface);

        $this->assertInstanceOf('\Symfony\Component\Routing\RouterInterface', $this->router);
    }

    public function testIsGeneratingUrl()
    {
        $mockRouterInterface = $this->getMockBuilder('\Symfony\Component\Routing\RouterInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockRouterInterface->expects($this->once())
            ->method('generate')
            ->with($this->equalTo('route'), $this->equalTo(['parameters' => 'parameters']), 'reference_type')
            ->will($this->returnValue('generated_url'));

        $this->router = $mockRouterInterface;

        $actual = $this->generateUrl('route', ['parameters' => 'parameters'], 'reference_type');

        $this->assertEquals('generated_url', $actual);
    }

    public function testIsGeneratingUrlWithoutReferenceTypeParam()
    {
        $mockRouterInterface = $this->getMockBuilder('\Symfony\Component\Routing\RouterInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockRouterInterface->expects($this->once())
            ->method('generate')
            ->with($this->equalTo('route'), $this->equalTo(['parameters' => 'parameters']), $this->equalTo(UrlGeneratorInterface::ABSOLUTE_PATH))
            ->will($this->returnValue('generated_url'));

        $this->router = $mockRouterInterface;

        $actual = $this->generateUrl('route', ['parameters' => 'parameters']);

        $this->assertEquals('generated_url', $actual);
    }

    public function testIsCreatingRedirectResponse()
    {
        $redirectUrl = 'http://test.local/redirect';

        $result = $this->redirect($redirectUrl);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $result);
        $this->assertEquals($redirectUrl, $result->getTargetUrl());
        $this->assertEquals(302, $result->getStatusCode());
    }

    public function testIsCreatingRedirectResponseWithCustomStatusCode()
    {
        $redirectUrl = 'http://test.local/redirect';
        $statusCode = 301;

        $result = $this->redirect($redirectUrl, $statusCode);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $result);
        $this->assertEquals($redirectUrl, $result->getTargetUrl());
        $this->assertEquals($statusCode, $result->getStatusCode());
    }

    public function testIsCreatingRedirectResponseToRoute()
    {
        $mockRouterInterface = $this->getMockBuilder('\Symfony\Component\Routing\RouterInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockRouterInterface->expects($this->once())
            ->method('generate')
            ->with($this->equalTo('route'), $this->equalTo(['parameters' => 'parameters']), $this->equalTo(UrlGeneratorInterface::ABSOLUTE_PATH))
            ->will($this->returnValue('generated_url'));

        $this->router = $mockRouterInterface;

        $result = $this->redirectToRoute('route', ['parameters' => 'parameters']);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $result);
        $this->assertEquals('generated_url', $result->getTargetUrl());
        $this->assertEquals(302, $result->getStatusCode());
    }

    public function testIsCreatingRedirectResponseToRouteWithCustomStatusCode()
    {
        $mockRouterInterface = $this->getMockBuilder('\Symfony\Component\Routing\RouterInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockRouterInterface->expects($this->once())
            ->method('generate')
            ->with($this->equalTo('route'), $this->equalTo(['parameters' => 'parameters']), $this->equalTo(UrlGeneratorInterface::ABSOLUTE_PATH))
            ->will($this->returnValue('generated_url'));

        $this->router = $mockRouterInterface;

        $result = $this->redirectToRoute('route', ['parameters' => 'parameters'], 301);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\RedirectResponse', $result);
        $this->assertEquals('generated_url', $result->getTargetUrl());
        $this->assertEquals(301, $result->getStatusCode());
    }
}
