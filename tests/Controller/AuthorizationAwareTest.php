<?php

namespace Linio\Controller;

class AuthorizationAwareTest extends \PHPUnit_Framework_TestCase
{
    use AuthorizationAware;

    public function testIsGettingAuthorizationChecker()
    {
        $this->authorizationChecker = $this->getMockBuilder('\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface')
            ->getMock();

        $actual = $this->getAuthorizationChecker();

        $this->assertInstanceOf('\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface', $actual);
    }

    public function testIsSettingFormFactory()
    {
        $mockAuthorizationChecker = $this->getMockBuilder('\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface')
            ->getMock();

        $this->setAuthorizationChecker($mockAuthorizationChecker);

        $this->assertInstanceOf('Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface', $this->authorizationChecker);
    }

    public function testIsCheckingGrantedTrue()
    {
        $mockAuthorizationChecker = $this->getMockBuilder('\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface')
            ->getMock();

        $this->authorizationChecker = $mockAuthorizationChecker;

        $this->authorizationChecker->method('isGranted')->with('ROLE_TEST')->willReturn(true);

        $actual = $this->isGranted('ROLE_TEST');

        $this->assertTrue($actual);
    }

    public function testIsCheckingGrantedFalse()
    {
        $mockAuthorizationChecker = $this->getMockBuilder('\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface')
            ->getMock();

        $this->authorizationChecker = $mockAuthorizationChecker;

        $this->authorizationChecker->method('isGranted')->with('ROLE_TEST')->willReturn(false);

        $actual = $this->isGranted('ROLE_TEST');

        $this->assertFalse($actual);
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function testDenyAccessUnlessGrantedDenied()
    {
        $mockAuthorizationChecker = $this->getMockBuilder('\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface')
            ->getMock();

        $this->authorizationChecker = $mockAuthorizationChecker;

        $this->authorizationChecker->method('isGranted')->with('ROLE_TEST')->willReturn(false);

        $actual = $this->denyAccessUnlessGranted('ROLE_TEST');
    }

    public function testDenyAccessUnlessGrantedAllowed()
    {
        $mockAuthorizationChecker = $this->getMockBuilder('\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface')
            ->getMock();

        $this->authorizationChecker = $mockAuthorizationChecker;

        $this->authorizationChecker->method('isGranted')->with('ROLE_TEST')->willReturn(true);

        $actual = $this->denyAccessUnlessGranted('ROLE_TEST');

        $this->assertNull($actual);
    }
}
