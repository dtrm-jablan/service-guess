<?php namespace Determine\Service\Guess\Utility;

use Elasticsearch\Transport;
use Elasticsearch\ClientBuilder as BaseClientBuilder;

class ClientBuilder extends BaseClientBuilder
{
    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * @param Transport $transport
     * @param callable  $endpoint
     *
     * @return Client
     */
    protected function instantiate(Transport $transport, callable $endpoint)
    {
        return new Client($transport, $endpoint);
    }
}
