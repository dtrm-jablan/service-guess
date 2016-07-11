<?php namespace Determine\Service\Guess\Exceptions;

use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Elasticsearch\Common\Exceptions\ElasticsearchException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /** @inheritdoc */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
//        if ($e instanceof HttpException || $e instanceof ElasticsearchException || '/api' == substr($request->getRequestUri(), 4)) {
//            return $this->renderJsonException($request, $e);
//        }

        return parent::render($request, $e);
    }

//    /**
//     * Hijacked to convert API errors to json
//     *
//     * @param Request                                                          $request
//     * @param \Exception|\Symfony\Component\HttpKernel\Exception\HttpException $exception
//     *
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    protected function renderJsonException(Request $request, \Exception $exception)
//    {
//        return \Response::json([
//            'error'   => $exception->getMessage(),
//            'code'    => $exception->getCode(),
//            'request' => $request->getRequestUri(),
//        ],
//            $exception->getCode());
//    }
}
