<?php

namespace app\model;

use think\model\concern\SoftDelete;

class Project extends Base
{
    use SoftDelete;

    protected $table = 'project';
    
    // 指定软删除字段
    protected $deleteTime = 'deleted_at';
}
