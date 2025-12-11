<?php

namespace app\admin\controller;

use app\admin\service\FileCategoryService;
use app\admin\service\ProductCategoryService;
use app\admin\service\ProductService;
use app\admin\validate\ProductValidate;
use think\App;
use think\facade\View;

class Product extends Base
{
    protected ProductService $product;
    protected ProductCategoryService $productCategory;
    protected FileCategoryService $fileCategory;
    protected ProductValidate $productValidate;

    public function __construct(App $app)
    {
        $this->product = new ProductService();
        $this->productCategory = new ProductCategoryService();
        $this->fileCategory = new FileCategoryService();
        $this->productValidate = new ProductValidate();
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
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        return View::fetch('admin@product/create');
    }

    // 产品新增
    public function create()
    {
        // 简单验证下参数
        $param = $this->request->post();
        if (!$this->productValidate->scene('create')->check($param)) {
            return $this->err($this->productValidate->getError());
        }

        $userID = $this->request->user['id'];
        $id = $this->product->create($param, $userID);
        if (!$id) {
            return $this->err('保存失败');
        }

        return $this->suc();
    }

    // 产品编辑（页面）
    public function updateHtml($id = 0)
    {
        // 产品分类
        $all = $this->productCategory->all();
        View::assign('productCategory', $all);
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);

        $id = $this->request->route('id');
        $info = $this->product->info($id);
        View::assign('info', $info);
        return View::fetch('admin@product/update');
    }

    // 产品编辑
    public function update()
    {
        // 简单验证下参数
        $data = $this->request->post();
        if (!$this->productValidate->scene('update')->check($data)) {
            return $this->err($this->productValidate->getError());
        }

        $this->product->update($data);
        return $this->suc();
    }

    // 产品删除
    public function delete()
    {
        $ids = input('post.ids', []);
        if (!$ids && !is_array($ids)) {
            return $this->err('未选择要删除产品');
        }

        // 是否选择正确
        $check = $this->product->checkSelect($ids);
        if (!$check) {
            return $this->err('产品选择错误');
        }

        $this->product->delete($ids);

        return $this->suc();
    }
}
