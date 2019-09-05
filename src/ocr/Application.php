<?php
namespace kkse\baidu_ai\ocr;

use kkse\baidu_ai\kernel\SubServiceContainer;

/**
 * Class Application
 * @package kkse\baidu_ai\ocr
 * @property idcard\Client $idcard
 * @property bankcard\Client $bankcard
 * @property business_license\Client $business_license
 */
class Application extends SubServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        idcard\ServiceProvider::class,
        bankcard\ServiceProvider::class,
        business_license\ServiceProvider::class
    ];
}