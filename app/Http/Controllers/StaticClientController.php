<?php namespace Determine\Service\Guess\Http\Controllers;

use Determine\Service\Guess\Traits\RestExceptionHandler;
use Determine\Service\Guess\Utility\Client;
use Determine\Service\Guess\Utility\ClientBuilder;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Elasticsearch\Common\Exceptions\ElasticsearchException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StaticClientController extends BaseController
{
    //******************************************************************************
    //* Traits
    //******************************************************************************

    use RestExceptionHandler;

    //******************************************************************************
    //* Members
    //******************************************************************************

    /**
     * @var Client
     */
    protected static $client;
    /**
     * @var bool If true, a Response object is returned from __call. Otherwise the raw results are returned.
     */
    protected static $genericResponse = true;

    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * @param array|null|bool $config Config hash. Defaults to the "guess.elastic" configuration hash. Set to FALSE to force a fresh client
     *
     * @return Client
     */
    protected static function getClient($config = null)
    {
        if (false === $config) {
            static::$client = $config = null;
        }

        empty($config) && $config = config('guess.elastic', []);

        return static::$client ?: static::$client = ClientBuilder::fromConfig($config);
    }

    /**
     * @param string $method
     * @param array  $params
     * @param bool   $raw
     *
     * @return \Illuminate\Http\Response|mixed
     * @throws \Exception
     */
    protected function doCall($method, $params = [], $raw = false)
    {
        if (!method_exists($_client = static::getClient(), $method)) {
            return parent::__call($method, $params);
        }

        try {
            $_result = $_client->{$method}($params);

            return ($raw || !static::$genericResponse) ? $_result : $this->respond($_result);
        } catch (\Exception $_ex) {
            empty($_code = $_ex->getCode()) && $_code = Response::HTTP_INTERNAL_SERVER_ERROR;

            \Log::error('[api] "' . $method . '" exception: ' . $_ex->getMessage(), ['params' => $params]);

            if ($raw || !static::$genericResponse) {
                throw $_ex;
            }

            return $this->respondWithError($_ex->getMessage(), $_code);
        }
    }

    /**
     * Get's the posted/put content
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool|array
     */
    protected function getContent(Request $request)
    {
        if (is_array($_data = $request->getContent())) {
            return $_data;
        }

        if (is_string($_data) && false !== ($_decoded = json_decode($_data, true)) && !empty($_decoded)) {
            return $_decoded;
        }

        //  No clue
        return false;
    }
}
