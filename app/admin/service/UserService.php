<?php

namespace app\admin\service;

use app\admin\repository\UserRepository;

class UserService extends BaseService
{
    protected UserRepository $user;

    public function __construct()
    {
        $this->user = new UserRepository();
    }

    // 密码验证
    public function checkPassword(string $username, string $password): array
    {
        // 默认时空
        $checkPasswordRes = [
            'status' => false,
            'user' => [],
            'jwt' => [],
        ];

        // 获取用户
        $info = $this->user->infoByUserName($username);
        if (!$info) {
            return $checkPasswordRes;
        }

        // 验证密码
        $salt = $info->salt;
        $saltString = base64_encode($salt);
        $passwordHash = $info->password;

        // 使用盐直接与密码进行验证
        if (password_verify($password . $saltString, $passwordHash)) {
            $checkPasswordRes['status'] = true;
            // 仅返回一些基本信息
            $checkPasswordRes['user'] = [
                'id' => $info->id,
                'username' => $info->username,
                'email' => $info->email,
                'phone' => $info->phone,
                'uuid' => $info->uuid
            ];
            $checkPasswordRes['jwt'] = [
                'username' => $info->username
            ];
            return $checkPasswordRes;
        }

        return $checkPasswordRes;
    }
}
