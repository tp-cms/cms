<?php

namespace app\trait;

use app\enum\ResponseCodeEnum;

trait ResponseTrait
{

    private function jsonResp($code = ResponseCodeEnum::SuccessCoce->value, $message = '成功', $data = [])
    {
        $status = $code == ResponseCodeEnum::SuccessCoce->value ? true : false;
        return json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function suc($data = [])
    {
        return $this->jsonResp(ResponseCodeEnum::SuccessCoce->value, '成功', $data);
    }

    public function err($message = '失败', $data = [])
    {
        return $this->jsonResp(ResponseCodeEnum::ErrorCode->value, $message, $data);
    }

    public function unauthorized()
    {
        return $this->jsonResp(ResponseCodeEnum::UnauthorizedCode->value, '未登录');
    }
}
