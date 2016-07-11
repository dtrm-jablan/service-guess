<?php namespace Determine\Service\Guess\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /** @inheritdoc */
    protected $except = [];
}
