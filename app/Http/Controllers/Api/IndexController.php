<?php namespace Determine\Service\Guess\Http\Controllers\Api;

use Determine\Service\Guess\Http\Controllers\StaticIndicesController;
use Illuminate\Http\Request;

class IndexController extends StaticIndicesController
{
    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index
     *
     * @return \Illuminate\Http\Response|mixed
     */
    public function get(Request $request, $index)
    {
        logger('[api.index] "get" request received', ['index' => $index]);

        if ($request->isMethod('HEAD')) {
            return $this->exists($request, $index);
        }

        return $this->doCall('get', array_merge($request->query->all(), ['index' => $index]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index
     *
     * @return \Illuminate\Http\Response|mixed
     */
    public function create(Request $request, $index)
    {
        logger('[api.index] "create" request received', ['index' => $index]);

        return $this->doCall('create', array_merge($request->query->all(), ['index' => $index]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index
     *
     * @return \Illuminate\Http\Response|mixed
     */
    public function delete(Request $request, $index)
    {
        logger('[api.index] "delete" request received', ['index' => $index]);

        return $this->doCall('delete', array_merge($request->query->all(), ['index' => $index]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index
     *
     * @return \Illuminate\Http\Response|mixed
     */
    public function open(Request $request, $index)
    {
        logger('[api.index] "open" request received', ['index' => $index]);

        return $this->doCall('open', array_merge($request->query->all(), ['index' => $index]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index
     *
     * @return \Illuminate\Http\Response|mixed
     */
    public function close(Request $request, $index)
    {
        logger('[api.index] "close" request received', ['index' => $index]);

        return $this->doCall('close', array_merge($request->query->all(), ['index' => $index]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $index A comma-separated list of indices to check
     *
     * @return bool
     */
    public function exists(Request $request, $index)
    {
        logger('[api.index] "exists" request received', ['index' => $index]);

        return $this->doCall('exists', array_merge($request->query->all(), ['index' => $index]));
    }
}
