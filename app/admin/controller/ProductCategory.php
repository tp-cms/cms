<?php

namespace app\admin\controller;

use app\admin\service\ProductCategoryService;
use app\admin\validate\ProductCategoryValidate;
use think\App;
use think\facade\View;

class ProductCategory extends Base
{
    protected ProductCategoryService $productCategory;
    protected ProductCategoryValidate $productCategoryValidate;

    public function __construct(App $app)
    {
        $this->productCategory = new ProductCategoryService();
        $this->productCategoryValidate = new ProductCategoryValidate();
        return parent::__construct($app);
    }

    // 列表
    public function indexHtml()
    {
        return View::fetch('admin@productcategory/index');
    }

    public function index()
    {
        $keyword = input('post.keyword', '');
        $page = input('post.page', 1);
        if (strlen($keyword) > 26) {
            return $this->err('搜索内容不可超出26个字符');
        }

        $list = $this->productCategory->index($keyword, $page);
        return $this->suc($list);
    }

    // 添加
    public function createHtml()
    {
        return View::fetch('admin@productcategory/create');
    }

    public function create()
    {
        $param = $this->request->post();
        if (!$this->productCategoryValidate->scene('create')->check($param)) {
            return $this->err($this->productCategoryValidate->getError());
        }

        // 检查下是否重复
        if ($this->productCategory->duplicate($param['name'], $param['code'])) {
            return $this->err('名称/code已存在');
        }

        $userID = $this->request->user['id'];
        $id = $this->productCategory->create($param, $userID);
        if (!$id) {
            return $this->err('新增失败');
        }

        return $this->suc();
    }

    // 更新
    public function updateHtml()
    {
        $id = $this->request->route('id');
        $info = $this->productCategory->info($id);
        if (!$info) {
            return View::fetch('admin@tips/notfound');
        }
        View::assign('info', $info);
        return View::fetch('admin@productcategory/update');
    }

    public function update()
    {
        $param = $this->request->post();
        if (!$this->productCategoryValidate->scene('update')->check($param)) {
            return $this->err($this->productCategoryValidate->getError());
        }

        // 检查下是否重复
        if ($this->productCategory->duplicate($param['name'], $param['code'], $param['id'])) {
            return $this->err('名称/code已存在');
        }

        $this->productCategory->update($param);

        return $this->suc();
    }

    // 删除
    public function delete()
    {
        $ids = input('post.ids', []);
        if (!$ids && !is_array($ids)) {
            return $this->err('未选择要删除分类');
        }

        // 是否选择正确
        $check = $this->productCategory->selectedCount($ids);
        if (!$check) {
            return $this->err('分类选择错误');
        }

        // 删除前判断
        $hasProduct = $this->productCategory->hasProductInCategory($ids);
        if ($hasProduct) {
            return $this->err('请先删除分类下的分类信息');
        }

        $this->productCategory->delete($ids);

        return $this->suc();
    }
}
