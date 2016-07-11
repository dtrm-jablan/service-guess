<?php namespace Determine\Service\Guess\Http;

use Determine\Service\Guess\Http\Middleware\Authenticate;
use Determine\Service\Guess\Http\Middleware\EncryptCookies;
use Determine\Service\Guess\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\Authorize;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends HttpKernel
{
    /** @inheritdoc */
    protected $middleware = [
        CheckForMaintenanceMode::class,
    ];

    /** @inheritdoc */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            //            Middleware\VerifyCsrfToken::class,
        ],
        'api' => [
            //'throttle:60,1',
        ],
    ];

    /** @inheritdoc */
    protected $routeMiddleware = [
        'auth'       => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'can'        => Authorize::class,
        'guest'      => RedirectIfAuthenticated::class,
        'throttle'   => ThrottleRequests::class,
    ];
}
