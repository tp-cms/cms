<?php

namespace app\trait;

trait ResponseTrait
{

    private const success = 25127;
    private const error = 10000;
    private const unauthorized = 14297;

    private function jsonResp($code = self::success, $message = '成功', $data = [])
    {
        $status = $code == self::success ? true : false;
        return json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function suc($data = [])
    {
        return $this->jsonResp(self::success, '成功', $data);
    }

    public function err($message = '失败', $data = [])
    {
        return $this->jsonResp(self::error, $message, $data);
    }

    public function unauthorized()
    {
        return $this->jsonResp(self::unauthorized, '未登录');
    }
}
