<?php namespace Determine\Service\Guess\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

class EncryptCookies extends BaseEncrypter
{
    /** @inheritdoc */
    protected $except = [];
}
