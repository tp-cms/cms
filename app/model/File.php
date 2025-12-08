<?php

namespace app\model;

use think\model\concern\SoftDelete;

class File extends Base
{
    use SoftDelete;

    protected $table = 'file';

    // 指定软删除字段
    protected $deleteTime = 'deleted_at';

    // 允许写入字段
    protected $field = [
        'name',
        'hash_name',
        'path',
        'size',
        'ext',
        'mime',
        'created_by',
        'created_at',
        'updated_at'
    ];

    // 存储类型
    public const fileStorageTypeLocal = 1;
}
