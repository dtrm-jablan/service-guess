<?php namespace Determine\Service\Guess\Utility;

use GuzzleHttp\Ring\Future\FutureArrayInterface;
use Elasticsearch\Client as BaseClient;

class Client extends BaseClient
{
    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * @param string $method
     * @param string $uri
     * @param array  $params
     * @param array  $body
     * @param array  $options
     *
     * @return array|callable
     */
    public function raw($method, $uri, $params = [], $body = [], $options = [])
    {
        $_response = $this->transport->performRequest($method, $uri, $params, $body, $options);

        $_result = $this->resultOrFuture($_response);

        return $_result;
    }

    /**
     * @param object $result
     *
     * @return object
     */
    public function resultOrFuture($result)
    {
        $_future = $_response = null;
        //$_future = isset($this->options['client']['future']) ? $this->options['client']['future'] : null;

        if (true === $_future || 'lazy' == $_future) {
            return $result;
        }

        do {
            $result = $result->wait();
        } while ($result instanceof FutureArrayInterface);

        return $result;
    }
}
