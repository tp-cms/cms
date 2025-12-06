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

    public function index($keyword = '', $category = 0, $page = 1, $perPage = 20)
    {
        return $this->product->index($keyword, $category, $page, $perPage);
    }
}
