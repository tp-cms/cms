<?php

namespace app\model;

use think\model\concern\SoftDelete;

class User extends Base
{
    use SoftDelete;

    protected $table = 'user';

    // 指定软删除字段
    protected $deleteTime = 'deleted_at';
}
