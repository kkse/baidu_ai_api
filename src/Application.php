<?php
namespace kkse\baidu_ai;

use kkse\baidu_ai\kernel\ServiceContainer;

/**
 * Class Application 123
 * @package kkse\baidu_ai
 * @property ocr\Application $ocr
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        ocr\ServiceProvider::class,
    ];
}
