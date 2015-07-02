<?php

namespace Linio\Request\Transformer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Linio\Request\Transformer\Exception\JsonRequestTransformerException;

/**
 * Class JsonRequestTransformerListener
 * @package Linio\Request\Transformer
 */
class JsonRequestTransformerListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->getContentType() !== 'json') {
            return;
        }

        try {
            $this->transformJsonBody($request);
        } catch (JsonRequestTransformerException $e) {
            $response = Response::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }

    /**
     * @param Request $request
     * @throws JsonRequestTransformerException
     */
    protected function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $message = 'Malformed input data';

            if (function_exists('json_last_error_msg')) {
                $message = json_last_error_msg();
            }

            throw new JsonRequestTransformerException($message);
        }

        $request->request->replace($data);
    }
}
