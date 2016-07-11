<?php namespace Determine\Service\Guess\Http\Controllers\Api;

use Determine\Service\Guess\Http\Controllers\StaticClientController;
use Elasticsearch\Common\Exceptions\ElasticsearchException;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DefaultController extends StaticClientController
{
    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * @return \Illuminate\Http\Response|mixed
     */
    public function info()
    {
        return $this->doCall('info');
    }

    /**
     * Generic pass-thru
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $uri
     *
     * @return \Illuminate\Http\Response|mixed
     * @throws \Exception
     */
    public function handleRequest(Request $request, $uri = null)
    {
        logger('[api.default] request received', ['request' => $request->toArray(), 'uri' => $uri]);

        $uri = '/' . trim($uri, ' /');

        try {
            $_result = static::getClient()->raw($request->method(), $uri, $request->query->all(), $request->json());
        } catch (\Exception $_ex) {
            if ($_ex instanceof ElasticsearchException) {
                $_json = $_ex->getMessage();
                if (false !== ($_json = json_decode($_json))) {
                    return \Response::json(['success' => false, 'code' => $_ex->getCode(), 'response' => $_json]);
                }
            }

            \Log::error('[api.default] request error [' . $_ex->getCode() . ']: ' . $_ex->getMessage());

            return \Response::json(['success' => false, 'code' => $_ex->getCode(), 'response' => $_ex->getMessage()]);
        }

        return \Response::json(['success' => true, 'code' => Response::HTTP_OK, 'response' => $_result]);
    }
}
