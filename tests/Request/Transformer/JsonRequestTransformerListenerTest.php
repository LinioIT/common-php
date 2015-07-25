<?php

namespace Linio\Request\Transformer\Tests;

use Prophecy\Argument;
use Linio\Request\Transformer\JsonRequestTransformerListener;
use Symfony\Component\HttpFoundation\Response;

class JsonRequestTransformerListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testIsOnKernelRequestReplacingDecodedContent()
    {
        $responseEventMock = $this->prophesize('Symfony\Component\HttpKernel\Event\GetResponseEvent');
        $requestMock = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $requestAttributeMock = $this->prophesize('Symfony\Component\HttpFoundation\ParameterBag');

        $content = '{"customerAddress":{"firstName":"FirstName", "lastName":"LastName"}}';

        $decodedContent = [
            'customerAddress' => [
                'firstName' => 'FirstName',
                'lastName' => 'LastName',
            ],
        ];

        $requestMock->getContentType()
            ->shouldBeCalled()
            ->willReturn('json');

        $requestMock->getContent()
            ->shouldBeCalled()
            ->willReturn($content);

        $requestAttributeMock->replace($decodedContent)
            ->shouldBeCalled();

        $requestMock->request = $requestAttributeMock;

        $responseEventMock->getRequest()
            ->shouldBeCalled()
            ->willReturn($requestMock);

        $jsonRequestTransformerListener = new JsonRequestTransformerListener();
        $jsonRequestTransformerListener->onKernelRequest($responseEventMock->reveal());
    }

    public function testIsOnKernelRequestSettingABadResponse()
    {
        $responseEventMock = $this->prophesize('Symfony\Component\HttpKernel\Event\GetResponseEvent');
        $requestMock = $this->prophesize('Symfony\Component\HttpFoundation\Request');

        $content = '{"customerAddress":"firstName":"FirstName" "lastName":"LastName"}}';

        $requestMock->getContentType()
            ->shouldBeCalled()
            ->willReturn('json');

        $requestMock->getContent()
            ->shouldBeCalled()
            ->willReturn($content);

        $responseEventMock->getRequest()
            ->shouldBeCalled()
            ->willReturn($requestMock);

        $responseEventMock->setResponse(Argument::type('Symfony\Component\HttpFoundation\Response'))
            ->shouldBeCalled();

        $jsonRequestTransformerListener = new JsonRequestTransformerListener();
        $jsonRequestTransformerListener->onKernelRequest($responseEventMock->reveal());
    }

    public function testIsOnKernelRequestJustReturning()
    {
        $responseEventMock = $this->prophesize('Symfony\Component\HttpKernel\Event\GetResponseEvent');
        $requestMock = $this->prophesize('Symfony\Component\HttpFoundation\Request');

        $requestMock->getContentType()
            ->shouldBeCalled()
            ->willReturn('html');

        $responseEventMock->getRequest()
            ->shouldBeCalled()
            ->willReturn($requestMock);

        $jsonRequestTransformerListener = new JsonRequestTransformerListener();
        $jsonRequestTransformerListener->onKernelRequest($responseEventMock->reveal());
    }
}
