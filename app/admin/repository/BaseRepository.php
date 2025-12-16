<?php

namespace app\admin\repository;

use think\facade\Db;

class BaseRepository
{
    // 选择有效记录数量
    public function selectedCount($table, $ids)
    {
        if (!$ids) {
            return 0;
        }
        return Db::name($table)->whereIn('id', $ids)->count('id');
    }
}
