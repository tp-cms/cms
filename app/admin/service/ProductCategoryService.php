<?php

namespace app\admin\service;

use app\admin\repository\ProductCategoryRepository;

class ProductCategoryService extends BaseService
{
    protected ProductCategoryRepository $productCategory;

    public function __construct()
    {
        $this->productCategory = new ProductCategoryRepository();
    }

    public function all(){
        return $this->productCategory->all();
    }
}
