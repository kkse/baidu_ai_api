<?php

namespace kkse\baidu_ai\kernel\traits;

use InvalidArgumentException;
use kkse\baidu_ai\kernel\contracts\Arrayable;
use kkse\baidu_ai\kernel\http\Response;
use kkse\baidu_ai\kernel\support\Collection;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Trait ResponseCastable
 * @package kkse\baidu_ai\kernel\traits
 */
trait ResponseCastable
{
    /**
     * @param ResponseInterface $response
     * @param null $type
     * @return array|Response|Collection|object|ResponseInterface
     */
    protected function castResponseToType(ResponseInterface $response, $type = null)
    {
        $response = Response::buildFromPsrResponse($response);
        $response->getBody()->rewind();

        switch ($type ?? 'array') {
            case 'collection':
                return $response->toCollection();
            case 'array':
                return $response->toArray();
            case 'object':
                return $response->toObject();
            case 'raw':
                return $response;
            default:
                if (!is_subclass_of($type, Arrayable::class)) {
                    throw new RuntimeException(sprintf(
                        'Config key "response_type" classname must be an instanceof %s',
                        Arrayable::class
                    ));
                }

                return new $type($response);
        }
    }

    /**
     * @param $response
     * @param null $type
     * @return array|Collection|object|ResponseInterface|string
     */
    protected function detectAndCastResponseToType($response, $type = null)
    {
        switch (true) {
            case $response instanceof ResponseInterface:
                $response = Response::buildFromPsrResponse($response);

                break;
            case $response instanceof Arrayable:
                $response = new Response(200, [], json_encode($response->toArray()));

                break;
            case ($response instanceof Collection) || is_array($response) || is_object($response):
                $response = new Response(200, [], json_encode($response));

                break;
            case is_scalar($response):
                $response = new Response(200, [], $response);

                break;
            default:
                throw new InvalidArgumentException(sprintf('Unsupported response type "%s"', gettype($response)));
        }

        return $this->castResponseToType($response, $type);
    }
}
