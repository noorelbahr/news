<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            // Change default Laravel responses.
            return $this->handleJsonException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * @param $request
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleJsonException($request, Throwable $exception)
    {
        $code = (int) $exception->getCode();
        $responses = [
            'code' => ($code > 0 ? $code : 400),
            'message' => $exception->getMessage()
        ];

        if ($exception instanceof ModelNotFoundException) {
            $responses = ['code' => 404, 'message' => 'Data not found.'];
        } elseif ($exception instanceof NotFoundHttpException || $exception instanceof MethodNotAllowedHttpException) {
            $responses = ['code' => 404, 'message' => 'Not found.'];
        } elseif ($exception instanceof UnauthorizedException || $exception instanceof AuthenticationException) {
            $responses['code'] = 401;
        } elseif (is_a($exception, ValidationException::class)) {
            $responses['code'] = $exception->status;
            $responses['errors'] = $exception->errors();
        }

        // Get trace on development
        $isProduction = app()->environment('production');
        if (method_exists($exception, 'getTrace') &&
            !in_array(get_class($exception), $this->internalDontReport) &&
            !$isProduction) {
            $responses['dev-trace'] = $exception->getTrace();
        }

        return response()->json($responses, $responses['code']);
    }
}
