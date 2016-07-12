<?php namespace Determine\Service\Guess\Http\Controllers\Api;

use Determine\Service\Guess\Http\Controllers\StaticClientController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DocController extends StaticClientController
{
    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index The name of the index
     * @param string                   $type  The type of the document (use `_all` to fetch the first document matching the id across all types)
     * @param string                   $id    The document id
     *
     * @return \Illuminate\Http\Response|mixed
     */
    public function get(Request $request, $index, $type, $id)
    {
        if ($request->isMethod('HEAD')) {
            return $this->exists($request, $index, $type, $id);
        }

        logger('[api.doc] "get" request received', ['index' => $index]);

        return $this->doCall('get', array_merge($request->query->all(), ['index' => $index, 'type' => $type, 'id' => $id]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index The name of the index
     * @param string                   $type  The type of the document
     * @param string                   $id    The document id (if existing document)
     *
     * @return \Illuminate\Http\Response|mixed
     */
    public function create(Request $request, $index, $type, $id = null)
    {
        logger('[api.doc] "create" request received', ['index' => $index]);

        $_params = array_merge($request->query->all(), ['index' => $index, 'type' => $type, 'body' => $request->json()]);
        !empty($id) && $_params['id'] = $id;

        return $this->doCall('create', $_params);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index The name of the index
     * @param string                   $type  The type of the document (use `_all` to fetch the first document matching the id across all types)
     * @param string                   $id    The document id
     *
     * @return \Illuminate\Http\Response|mixed
     */
    public function exists(Request $request, $index, $type, $id)
    {
        logger('[api.doc] "exists" request received', ['index' => $index]);

        return $this->doCall('exists', array_merge($request->json(), ['index' => $index, 'type' => $type, 'id' => $id]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index The auto-suggest index
     * @param string                   $type  The auto-suggest type
     * @param string                   $text  The text to match
     *
     * @return \Illuminate\Http\Response|mixed
     * @internal param string $field The auto-suggest field
     */
    public function suggest(Request $request, $index, $type, $text)
    {
        $_search = $type . '_suggest';
        $_params = array_merge($request->query->all(),
            [
                'body' => [
                    $_search => [
                        'text'       => $text,
                        'completion' => [
                            'field' => SuggestController::SUGGEST_FIELD,
                        ],
                    ],
                ],
            ]);

        logger('[api.doc] "suggest" request received', ['index' => $index, 'params' => $_params]);

        $_result = $this->doCall('suggest', $_params, true);

        if (!empty($_suggest = data_get($_result, $_search))) {
            return $this->respond($_suggest);
        }

        return $this->respond($_result);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index
     * @param string                   $type
     * @param array|null               $seeds
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function seed(Request $request, $index, $type, $seeds = null)
    {
        logger('[api.suggest] "seed" request received', ['index' => $index, 'type' => $type]);

        if (empty($_data = $seeds ?: $this->getContent($request))) {
            \Log::error('[api.suggest] "seed" request payload bogus', ['index' => $index, 'type' => $type]);

            return $this->respondWithError('No content received', Response::HTTP_BAD_REQUEST);
        }

        $_results = [];
        $_baseParams = ['index' => $index, 'type' => $type];

        //  Put each seed
        foreach (array_get($_data, 'seeds', []) as $_seed) {
            $_params = $_baseParams;

            if (null !== ($_id = array_get($_seed, 'id'))) {
                array_forget($_seed, 'id');
                $_params['id'] = $_id;
            }

            $_params['body'] = $_seed;
            $_results[] = ['data' => $_seed, 'result' => $this->doCall('create', $_params)];

            unset($_seed, $_params);
        }

        return $this->respond($_results);
    }
}
