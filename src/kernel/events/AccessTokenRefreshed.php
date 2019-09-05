<?php

namespace kkse\baidu_ai\kernel\events;


use kkse\baidu_ai\kernel\AccessToken;

/**
 * Class AccessTokenRefreshed.
 */
class AccessTokenRefreshed
{
    /**
     * @var AccessToken
     */
    public $accessToken;

    /**
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
