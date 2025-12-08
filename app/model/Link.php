<?php

namespace app\model;

use think\model\concern\SoftDelete;

class Link extends Base
{
    use SoftDelete;

    protected $table = 'link';

    // 指定软删除字段
    protected $deleteTime = 'deleted_at';
}
