<?php

namespace Linio\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class RestController
{
    /**
     * @param string $message
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function abort($message = '', $status = 500)
    {
        return new JsonResponse(['error' => ['message' => empty($message) ? 'Internal error' : $message]], $status);
    }
}
