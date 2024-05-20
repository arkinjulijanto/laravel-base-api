<?php

namespace App\Http\Controllers;

use App\Enums\Retcode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class Controller
{
    public function responseJson($msg, $retcode, $data = [], $code = 200): JsonResponse
    {
        return response()->json([
            "msg" => $msg,
            "retcode" => $retcode,
            "data" => $data
        ], $code);
    }

    public function notFoundResponse($note, $msg = 'resource not found', $retcode = Retcode::NOT_FOUND_ERROR, $status = 404): JsonResponse
    {
        Log::error('Not Found: ' . $note);
        return $this->responseJson($msg, $retcode, null, $status);
    }

    public function errorResponse($error, $msg = 'please try again later', $retcode = Retcode::SERVER_ERROR, $status = 500): JsonResponse
    {
        Log::error('error :\n' . $error);
        Log::error('msg :\n' . $msg);
        error_log($error);
        return $this->responseJson($msg, $retcode, null, $status);
    }

    public function successResponse($msg, $data = null, $retcode = Retcode::SUCCESS, $status = 200): JsonResponse
    {
        return $this->responseJson($msg, $retcode, $data, $status);
    }


}
