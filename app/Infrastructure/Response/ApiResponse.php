<?php

namespace App\Infrastructure\Response;

trait ApiResponse
{

    public function responseError($message, $code = "", $data = "", $status = 500)
    {
        return jsend_error($message, $code, $data, $status);
    }

    public function responseSuccess($data = [], $status = 200)
    {
        return jsend_success($data, $status);
    }

    public function responseFail($data, $status = 422)
    {
        return jsend_fail($data, $status);
    }

}
