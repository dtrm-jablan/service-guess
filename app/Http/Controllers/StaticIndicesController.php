<?php namespace Determine\Service\Guess\Http\Controllers;

class StaticIndicesController extends StaticClientController
{
    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * Returns the indices namespace client object
     *
     * @param array|null|bool $config Config hash. Defaults to the "guess.elastic" configuration hash. Set to FALSE to force a fresh client
     *
     * @return \Elasticsearch\Namespaces\IndicesNamespace
     */
    protected static function getClient($config = null)
    {
        return parent::getClient($config)->indices();
    }
}
