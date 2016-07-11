<?php namespace Determine\Service\Guess\Http\Controllers\Api;

use Determine\Service\Guess\Http\Controllers\StaticClientController;
use Illuminate\Http\Request;

class GetController extends StaticClientController
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
        logger('[api.doc] "suggest" request received', ['index' => $index]);

        $_params = [
            $type . '_suggest' => [
                'text'       => $text,
                'completion' => ['field' => 'suggest'],
            ],
        ];

        array_merge($request->query->all(), $_params);
        $_result = $this->doCall('suggest', $_params, true);

        if (!empty($_suggest = data_get($_result, $type . '_suggest'))) {
            return $this->respond($_suggest);
        }

        return $this->respond($_result);
    }
}
