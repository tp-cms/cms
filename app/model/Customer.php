<?php

namespace app\model;

use think\model\concern\SoftDelete;

class Customer extends Base
{
    use SoftDelete;

    protected $table = 'customer';

    // 指定软删除字段
    protected $deleteTime = 'deleted_at';
}
