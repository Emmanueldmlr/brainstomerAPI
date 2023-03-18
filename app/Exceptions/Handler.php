<?php

namespace App\Exceptions;

//use App\Exceptions\Common\UserExistException;
use App\Exceptions\Common\ValidationException;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        $this->renderable(function (AuthenticationException $exception, $request) {
            $reponse = ['status' => 'error', 'message' => 'Un-authorized User'];
            return (new JsonResponse())
            ->setData($reponse)
            ->setStatusCode(403);
        });

        $this->renderable(function (ModelNotFoundException $exception, $request) {
            $reponse = ['status' => 'error', 'message' => 'Not Found'];
            return (new JsonResponse())
            ->setData($reponse)
            ->setStatusCode(404);
        });

        $this->renderable(function (Exception $exception, $request) {
            if ($exception instanceof ModelNotFoundException) {
                $reponse = ['status' => 'error', 'message' => 'Not Found'];
                return (new JsonResponse())
                ->setData($reponse)
                ->setStatusCode(404);
            }

//            Log::channel("slack")->notice( 'ERROR=' . 'internal_error' . '|MESSAGE=' . $exception->getMessage() .'|FILE=' . $exception->getFile() . '|LINE=' . $exception->getLine());
            Log::error('ERROR=' . 'internal_error' .
                    '|MESSAGE=' . $exception->getMessage() .
                    '|FILE=' . $exception->getFile() .
                  //  '|TRACE=' . $exception->getTraceAsString() .
                    '|LINE=' . $exception->getLine());

            return (new JsonResponse())
                            ->setData(['status' => 'error', 'message' => $exception->getMessage()])
                            ->setStatusCode(500);
        });
    }
}
