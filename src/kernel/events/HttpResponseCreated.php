<?php

namespace kkse\baidu_ai\kernel\events;

use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpResponseCreated.
 */
class HttpResponseCreated
{
    /**
     * @var ResponseInterface
     */
    public $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }
}
