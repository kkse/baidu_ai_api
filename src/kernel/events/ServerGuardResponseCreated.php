<?php

namespace kkse\baidu_ai\kernel\events;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ServerGuardResponseCreated.
 */
class ServerGuardResponseCreated
{
    /**
     * @var Response
     */
    public $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }
}
