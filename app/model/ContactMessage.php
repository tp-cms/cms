<?php

namespace app\model;

use think\model\concern\SoftDelete;

class ContactMessage extends Base
{
    use SoftDelete;

    protected $table = 'contact_message';
    
    // 指定软删除字段
    protected $deleteTime = 'deleted_at';
}
