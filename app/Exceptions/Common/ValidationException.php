<?php

namespace App\Exceptions\Common;

use App\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ValidationException extends BaseException
{
    protected $code = 422;

    public function __construct($errorMessage, $data)
    {
        $this->setErrorMessage($errorMessage);
        $this->data($data);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        $reponse = ['status' => 'error', 'message' => $this->errorMessage];
        if (!empty($this->data)) {
            $reponse['data'] = $this->data;
        }

        Log::channel("slack")->notice($this->errorMessage);

        return (new JsonResponse())
        ->setData($reponse)
        ->setStatusCode($this->code);
    }
}
