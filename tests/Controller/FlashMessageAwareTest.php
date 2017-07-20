<?php

declare(strict_types=1);

namespace Linio\Controller;

class FlashMessageAwareTest extends \PHPUnit_Framework_TestCase
{
    use FlashMessageAware;

    public function testIsGettingSession()
    {
        $this->session = $this->getMock('Symfony\Component\HttpFoundation\Session\Session');

        $actual = $this->getSession();

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Session', $actual);
    }

    public function testIsSettingSession()
    {
        $sessionMock = $this->getMock('Symfony\Component\HttpFoundation\Session\Session');

        $this->setSession($sessionMock);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Session', $this->session);
    }

    public function testIsAddingFlashMessage()
    {
        $type = 'notice';
        $message = 'Foo bar';

        $flashBagMock = $this->getMock('Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface');
        $flashBagMock->expects($this->once())
            ->method('add')
            ->with($type, $message);

        $sessionMock = $this->getMockBuilder('Symfony\Component\HttpFoundation\Session\Session')
            ->disableOriginalConstructor()
            ->getMock();
        $sessionMock->expects($this->once())
            ->method('getFlashBag')
            ->willReturn($flashBagMock);

        $this->session = $sessionMock;

        $this->addFlash($type, $message);
    }
}
