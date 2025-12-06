<?php

namespace app\admin\repository;

use app\model\ProductCategory;

class ProductCategoryRepository extends BaseRepository
{
    protected ProductCategory $productCategory;

    public function __construct()
    {
        $this->productCategory = new ProductCategory();
    }

    // 分类全部
    public function all()
    {
        // https://doc.thinkphp.cn/v8_0/query_data.html
        $names = $this->productCategory->column('name', 'id');
        return $names;
    }
}
