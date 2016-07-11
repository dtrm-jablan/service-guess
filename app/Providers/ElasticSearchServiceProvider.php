<?php namespace Determine\Service\Guess\Providers;

use Illuminate\Support\ServiceProvider;

class ElasticSearchServiceProvider extends ServiceProvider
{
    //******************************************************************************
    //* Constants
    //******************************************************************************

    const ALIAS = 'services.elastic-search';

    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * Register the service provider.
     */
    public function register()
    {
        //  Register the service
        $this->app->singleton(
            static::ALIAS,
            function ($app) {
                return new ElasticSearchService($app);
            }
        );
    }
}
