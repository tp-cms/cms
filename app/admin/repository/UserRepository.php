<?php

namespace app\admin\repository;

use app\model\User;

class UserRepository extends BaseRepository
{
    protected User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    // 用户保存（使命行）
    public function cmdSave($userData, $isCreate = false)
    {
        $where = ['id' => 1];
        if ($isCreate) {
            return $this->user->save($userData);
        } else {
            return $this->user->update($userData, $where);
        }
    }

    // 用户信息
    public function info(int $id)
    {
        return $this->user->field('id,username,email,phone,uuid')->where(['id' => $id])->find();
    }

    // 根据用户名获取用户信息
    public function infoByUserName(string $username)
    {
        $info = $this->user->field('id,username,uuid,salt,password,phone,email')->where(['username' => $username])->find();
        return $info;
    }
}
