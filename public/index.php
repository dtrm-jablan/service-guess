<?php
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

//  Composer...
require __DIR__ . '/../bootstrap/autoload.php';

if (!function_exists('__guess_index')) {
    function __guess_index()
    {
        /**
         * @var Kernel      $__guess_kernel
         * @var Application $__guess_app
         * @var Request     $__guess_request
         * @var Response    $__guess_response
         */

        //  Initialize laravel
        $__guess_app = require_once __DIR__ . '/../bootstrap/app.php';

        $__guess_kernel = $__guess_app->make('Illuminate\Contracts\Http\Kernel');
        $__guess_request = Illuminate\Http\Request::capture();

        //  Handle the request
        $__guess_response = $__guess_kernel->handle($__guess_request);
        $__guess_kernel->terminate($__guess_request, $__guess_response->send());
    }
}

//  Do it!
__guess_index();