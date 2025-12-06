<?php

namespace app\admin\controller;

use app\admin\service\ProductCategoryService;
use app\admin\service\ProductService;
use think\App;
use think\facade\View;

class Product extends Base
{
    protected ProductService $product;
    protected ProductCategoryService $productCategory;

    public function __construct(App $app)
    {
        $this->product = new ProductService();
        $this->productCategory = new ProductCategoryService();
        return parent::__construct($app);
    }

    // 产品列表（页面）
    public function indexHtml()
    {
        // 产品分类
        $all = $this->productCategory->all();
        View::assign('productCategory', $all);
        return View::fetch('admin@product/index');
    }

    // 产品列表（接口）
    public function index()
    {
        $page = input('post.p', 1);
        $keyword = input('post.keyword', '');
        $categoryId = input('post.category', 0);
        $list = $this->product->index($keyword, $categoryId, $page);
        return $this->suc($list);
    }

    // 产品新增（页面）
    public function createHtml()
    {
        // 产品分类
        $all = $this->productCategory->all();
        View::assign('productCategory', $all);
        return View::fetch('admin@product/create');
    }

    // 产品新增
    public function create() {}

    // 产品编辑（页面）
    public function updateHtml($id = 0)
    {
        // 产品分类
        $all = $this->productCategory->all();
        View::assign('productCategory', $all);
        $id = $this->request->route('id');
        $info = $this->product->info($id);
        View::assign('info', $info);
        return View::fetch('admin@product/update');
    }

    // 产品编辑
    public function update() {}

    // 产品删除
    public function delete() {}
}
