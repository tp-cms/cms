<?php

namespace app\model;

use think\Model;

class Base extends Model
{
    // 开启自动时间戳，并指定格式为 datetime
    protected $autoWriteTimestamp = 'datetime';

    // 自定义创建时间字段
    protected $createTime = 'created_at';

    // 自定义更新时间字段
    protected $updateTime = 'updated_at';
}
