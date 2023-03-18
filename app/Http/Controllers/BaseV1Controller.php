<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseV1Controller extends Controller
{
    /**
     * @param callable $action
     * @return JsonResponse|\Symfony\Component\HttpFoundation\JsonResponse
     */
    public function handleRequest(callable $action)
    {
        $resultData = $action();
        $responsePayload['status'] = 'success';
        $responsePayload['data'] = $resultData;
        ob_start('ob_gzhandler');
        return (new JsonResponse())->setData($responsePayload);
    }
}
