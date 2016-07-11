<?php
if (!function_exists('__guess_bootstrap')) {
    /**
     * @return \Illuminate\Foundation\Application
     */
    function __guess_bootstrap()
    {
        //  Create the app
        $_app = new Illuminate\Foundation\Application(realpath(dirname(__DIR__)));

        //  Bind our default services
        $_app->singleton('Illuminate\Contracts\Http\Kernel', 'Determine\Service\Guess\Http\Kernel');
        $_app->singleton('Illuminate\Contracts\Console\Kernel', 'Determine\Service\Guess\Console\Kernel');
        $_app->singleton('Illuminate\Contracts\Debug\ExceptionHandler', 'Determine\Service\Guess\Exceptions\Handler');

        //  Return the app
        return $_app;
    }
}

return __guess_bootstrap();
