<?php namespace Determine\Service\Guess\Services;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticSearchService
{
    //******************************************************************************
    //* Members
    //******************************************************************************

    /**
     * @var Client
     */
    protected static $client;

    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * Translate a static method call to an elasticsearch client method and return results
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        if (method_exists(static::getClient(), $name)) {
            return static::getClient()->{$name}($arguments);
        }

        throw new \BadMethodCallException('Method "' . $name . '" not found.');
    }

    /**
     * Gets the client
     *
     * @return \Elasticsearch\Client
     */
    protected static function getClient()
    {
        return static::$client ?: static::$client = ClientBuilder::fromConfig(['hosts' => config('guess.hosts')]);
    }
}

