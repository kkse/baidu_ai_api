<?php

namespace kkse\baidu_ai\kernel\contracts;


use ArrayAccess;

/**
 * Interface Arrayable
 * @package kkse\baidu_ai\kernel\contracts
 */
interface Arrayable extends ArrayAccess
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray();
}
