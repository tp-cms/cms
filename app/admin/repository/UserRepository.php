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

    // 用户信息
    public function info(int $id)
    {
        return $this->user->field('id,username,email,phone,uuid')->where(['id' => $id])->find();
    }

    // 命令行保存
    public function cmdSave($userData, $isCreate = false)
    {
        $where = ['id' => 1];
        if ($isCreate) {
            return $this->user->save($userData, $where);
        } else {
            return $this->user->update($userData, $where);
        }
    }
}
