<?php namespace Determine\Service\Guess\Http\Controllers\Api;

use Determine\Service\Guess\Http\Controllers\StaticIndicesController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SuggestController extends StaticIndicesController
{
    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index The name of the index
     * @param string                   $type  The type of the document
     *
     * @return \Illuminate\Http\Response|mixed
     */
    public function create(Request $request, $index, $type)
    {
        logger('[api.suggest] "create" request received', ['index' => $index, 'type' => $type]);

        $_base = ['index' => $index];

        try {
            //  Check the index
            if (!static::getClient()->exists($_base)) {
                $_response = static::getClient()->create(['index' => $index]);
                logger('[api.suggest] "create" request: index "' . $index . '" created.', $_response);
            }
        } catch (\Exception $_ex) {
            return $this->respondWithError('Cannot create index "' . $index . '"', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        //  Build the request
        $_payload = [
            $type => [
                'properties' => [
                    'name'    => 'string',
                    'suggest' => [
                        'type'            => 'completion',
                        'analyzer'        => 'simple',
                        'search_analyzer' => 'simple',
                        'payloads'        => true,
                    ],
                ],
            ],
        ];

        $_params = array_merge($request->query->all(), $_base, ['type' => $type, 'body' => $_payload]);

        return $this->doCall('putMapping', $_params);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index
     * @param string                   $type
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function seed(Request $request, $index, $type)
    {
        logger('[api.suggest] "seed" request received', ['index' => $index, 'type' => $type]);

        //  The request body should contain a hash of properties
        if (!is_array($_content = $request->json()) && !empty($_content)) {
            if (is_string($_content) && false === json_decode($_content)) {
                logger('[api.suggest] "seed" request content unparseable', ['content' => $_content]);
                $_content = [];
            }
        }

        if (empty($_content)) {
            \Log::error('[api.get] "seed" request content contains no seed data');

            return $this->respondWithError('No seed data supplied in request', Response::HTTP_BAD_REQUEST);
        }

        $_baseParams = ['index' => $index, 'type' => $type];
        $_results = [];

        //  Put each seed
        foreach ($_content as $_seed) {
            $_id = array_get($_seed, 'id');
            $_params = $_baseParams;
            $_id && $_params['id'] = $_id;
            $_results[] = ['data' => $_seed, 'result' => $this->doCall('put', $_params)];
        }

        return $this->respond($_results);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index
     * @param string                   $type
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $index, $type)
    {
        logger('[api.suggest] "delete" request received', ['index' => $index, 'type' => $type]);

        return $this->doCall('deleteMapping', ['index' => $index, 'type' => $type]);
    }
}
