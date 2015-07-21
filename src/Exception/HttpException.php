<?php

namespace Linio\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Crell\ApiProblem\ApiProblem;
use Psr\Log\LogLevel;

/**
 * HttpException aims to make it easier to handle public-facing
 * errors in API's. It implements the draft-nottingham-http-problem-07
 * RFC draft and abstracts it's usage by using the ApiProblem class.
 *
 * @link http://tools.ietf.org/html/draft-nottingham-http-problem-07
 */
class HttpException extends ErrorException implements HttpExceptionInterface
{
    /**
     * @return int
     */
    protected $statusCode;

    /**
     * @return array
     */
    protected $headers;

    /**
     * @var ApiProblem
     */
    protected $apiProblem;

    /**
     * @param string $message Error message
     * @param int $statusCode HTTP status code
     * @param int $code Internal code for the application error
     * @param string $logLevel Log level of the error, from Psr\Log\LogLevel
     * @param string $detail Optional further details on the error
     * @param array $headers Optional header response information
     */
    public function __construct($message, $statusCode, $code = 0, $logLevel = LogLevel::WARNING, $detail = null, array $headers = array())
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;

        $this->apiProblem = new ApiProblem($message, '#' . $code);
        $this->apiProblem->setStatus($statusCode);
        $this->apiProblem->setDetail($detail);

        parent::__construct($message, $code, $logLevel);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return ApiProblem
     */
    public function getApiProblem()
    {
        return $this->apiProblem;
    }
}
