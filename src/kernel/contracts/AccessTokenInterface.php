<?php

namespace kkse\baidu_ai\kernel\contracts;

use Psr\Http\Message\RequestInterface;

/**
 * Interface AuthorizerAccessToken.
 *
 */
interface AccessTokenInterface
{
    /**
     * @return array
     */
    public function getToken(): array;

    /**
     * @return AccessTokenInterface
     */
    public function refresh(): self;

    /**
     * @param RequestInterface $request
     * @param array                              $requestOptions
     *
     * @return RequestInterface
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface;
}
