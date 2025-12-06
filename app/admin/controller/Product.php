<?php

namespace app\admin\controller;

use app\admin\service\ProductService;
use think\App;
use think\facade\View;

class Product extends Base
{
    protected ProductService $product;

    public function __construct(App $app)
    {
        $this->product = new ProductService();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        View::assign('content', '产品');
        return View::fetch('admin@product/index');
    }

    // 产品列表
    public function index()
    {
        $page = input('post.p', 1);
        $keyword = input('post.keyword', '');
        $categoryId = input('post.category', 0);
        $list = $this->product->index($keyword, $categoryId, $page);
        return $this->suc($list);
    }
}
