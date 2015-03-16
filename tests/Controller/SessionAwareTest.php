<?php

namespace Linio\Controller;

class SessionAwareTest extends \PHPUnit_Framework_TestCase
{
    use SessionAware;

    public function testIsGettingSession()
    {
        $this->session = $this->getMock('Symfony\Component\HttpFoundation\Session\SessionInterface');

        $actual = $this->getSession();

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\SessionInterface', $actual);
    }

    public function testIsSettingSession()
    {
        $sessionMock = $this->getMock('Symfony\Component\HttpFoundation\Session\SessionInterface');

        $this->setSession($sessionMock);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\SessionInterface', $this->session);
    }
}
