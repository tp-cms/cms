<?php

namespace app\model;

use think\model\concern\SoftDelete;

class ProductCategory extends Base
{
    use SoftDelete;

    protected $table = 'product_category';

    // 指定软删除字段
    protected $deleteTime = 'deleted_at';
}
