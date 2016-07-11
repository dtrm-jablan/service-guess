<?php namespace Determine\Service\Guess\Traits;

use Illuminate\Http\Response;

/**
 * Stupid-simple responder trait
 */
trait RestExceptionHandler
{
    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * @param string|null $message
     * @param int         $statusCode
     * @param array       $content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError($message = null, $statusCode = Response::HTTP_BAD_REQUEST, $content = [])
    {
        return $this->respond([
            'error' => $message,
            'code'  => $statusCode,
            'data'  => $content,
        ],
            $statusCode);
    }

    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int        $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($payload = [], $statusCode = Response::HTTP_OK)
    {
        return \Response::json($payload = $payload ?: [], $statusCode);
    }
}
