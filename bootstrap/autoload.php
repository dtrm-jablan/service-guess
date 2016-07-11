<?php
//******************************************************************************
//* Application Autoloader
//******************************************************************************

define('LARAVEL_START', microtime(true));

if (!function_exists('__guess_autoload')) {
    /**
     * @return bool
     */
    function __guess_autoload()
    {
        $_vendorPath = __DIR__ . '/../vendor';

        //  Register The Composer Auto Loader
        require $_vendorPath . '/autoload.php';

        //  Laravel 5.1+
        /** @noinspection PhpIncludeInspection */
        file_exists($_vendorPath . '/compiled.php') && require $_vendorPath . '/compiled.php';

        return true;
    }
}

return __guess_autoload();
