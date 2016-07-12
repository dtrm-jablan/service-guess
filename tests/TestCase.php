<?php

use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://guess.3wipes.com';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $_app = require __DIR__ . '/../bootstrap/app.php';
        $_app->make(Kernel::class)->bootstrap();

        return $_app;
    }
}
