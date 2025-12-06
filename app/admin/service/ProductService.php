<?php

namespace app\admin\service;

use app\admin\repository\ProductRepository;

class ProductService extends BaseService
{
    protected ProductRepository $product;

    public function __construct()
    {
        $this->product = new ProductRepository();
    }

    // index
    public function index($keyword = '', $category = 0, $page = 1, $perPage = 20)
    {
        return $this->product->index($keyword, $category, $page, $perPage);
    }

    // 详情
    public function info($id)
    {
        $info = $this->product->info($id);
        if (!$info) {
            return [];
        }

        return $info->toArray();
    }
}
