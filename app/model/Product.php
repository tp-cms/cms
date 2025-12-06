<?php

namespace app\model;

use think\model\concern\SoftDelete;

class Product extends Base
{
    use SoftDelete;

    protected $table = 'product';

    // 指定软删除字段
    protected $deleteTime = 'deleted_at';
}
