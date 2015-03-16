<?php

namespace Linio\Controller;

use Linio\Test\UnitTestCase;

class RestControllerTest extends UnitTestCase
{
    public function testIsAbortingAction()
    {
        $controller = $this->getMockForAbstractClass('Linio\Controller\RestController');
        $response = $controller->abort('Oh crap!');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $response);
        $this->assertEquals('{"error":{"message":"Oh crap!"}}', $response->getContent());
    }
}
