<?php namespace Determine\Service\Guess\Http\Controllers\Api;

use Determine\Service\Guess\Http\Controllers\StaticIndicesController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SuggestController extends StaticIndicesController
{
    //******************************************************************************
    //* Constants
    //******************************************************************************

    /**
     * @var string
     */
    const SUGGEST_FIELD = 'lookup_suggest';

    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * Create a new suggester
     * Creates a mapping on an index for completion
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $index The name of the index (i.e. customer ID, "SPH_I")
     * @param string                   $type  The type of the document (i.e. table name, "DEPARTMENT")
     *
     * @return \Illuminate\Http\Response|mixed
     */
    public function create(Request $request, $index, $type)
    {
        $_base = ['index' => $index];

        logger('[api.suggest] "create" request received', ['index' => $index, 'type' => $type]);

        if (false === ($_data = $this->getContent($request))) {
            logger('[api.suggest] "create" request payload bogus', ['index' => $index, 'type' => $type]);

            return $this->respondWithError('No content received', Response::HTTP_BAD_REQUEST);
        }

        logger('[api.suggest] "create" request parameters', $_data);

        try {
            //  Check the index
            if (!static::getClient()->exists($_base)) {
                static::getClient()->create(['index' => $index]);
                logger('[api.suggest] "create" request: index "' . $index . '" created');
            } else {
                logger('[api.suggest] "create" request: index "' . $index . '" exists');

            }
        } catch (\Exception $_ex) {
            return $this->respondWithError('Cannot create index "' . $index . '"', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        //  Build the request
        $_payload = [
            $type => [
                'properties' => [
                    static::SUGGEST_FIELD => [
                        'type'            => 'completion',
                        'analyzer'        => 'simple',
                        'search_analyzer' => 'simple',
                        'payloads'        => true,
                    ],
                ],
            ],
        ];

        //  Body should have a list of property names and type
        if (!empty($_data)) {
            foreach ($_data as $_property => $_type) {
                array_set($_payload, $type . '.properties.' . $_property, ['type' => $_type]);
            }
        }

        $_params = array_merge($request->query->all(), $_base, ['type' => $type, 'body' => $_payload]);
        logger('[api.suggest] "create" request: index "' . $index . '" mapping request', $_payload);

        $_response = $this->doCall('putMapping', $_params);

        logger('[api.suggest] "create" request response: ' . $_response->getContent());

        return $_response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index The name of the index (i.e. customer ID, "SPH_I")
     * @param string                   $type  The type of the document (i.e. table name, "DEPARTMENT")
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $index, $type)
    {
        logger('[api.suggest] "delete" request received', ['index' => $index, 'type' => $type]);

        return $this->respond(['error' => 'Unsupported', 'code' => Response::HTTP_NOT_IMPLEMENTED]);
    }
}
