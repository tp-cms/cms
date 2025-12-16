<?php

namespace app\admin\controller;

use app\admin\service\FileCategoryService;
use app\admin\validate\FileCategoryValidate;
use think\App;
use think\facade\View;

class FileCategory extends Base
{
    protected FileCategoryService $fileCategory;
    protected FileCategoryValidate $fileCategoryValidate;

    public function __construct(App $app)
    {
        $this->fileCategory = new FileCategoryService();
        $this->fileCategoryValidate = new FileCategoryValidate();
        return parent::__construct($app);
    }

    // 列表
    public function indexHtml()
    {
        return View::fetch('admin@filecategory/index');
    }

    public function index()
    {
        $keyword = input('post.keyword', '');
        $page = input('post.page', 1);
        if (strlen($keyword) > 26) {
            return $this->err('搜索内容不可超出26个字符');
        }

        $list = $this->fileCategory->index($keyword, $page);
        return $this->suc($list);
    }

    // 新增
    public function createHtml()
    {
        return View::fetch('admin@filecategory/create');
    }

    public function create()
    {
        $param = $this->request->post();
        if (!$this->fileCategoryValidate->scene('create')->check($param)) {
            return $this->err($this->fileCategoryValidate->getError());
        }

        // 检查下是否重复
        if ($this->fileCategory->duplicate($param['name'], $param['code'])) {
            return $this->err('名称/code已存在');
        }

        $userID = $this->request->user['id'];
        $id = $this->fileCategory->create($param, $userID);
        if (!$id) {
            return $this->err('新增失败');
        }

        return $this->suc();
    }

    // 更新
    public function updateHtml()
    {
        $id = $this->request->route('id');
        $info = $this->fileCategory->info($id);
        if (!$info) {
            return View::fetch('admin@tips/notfound');
        }
        View::assign('info', $info);
        return View::fetch('admin@filecategory/update');
    }

    public function update()
    {
        $param = $this->request->post();
        if (!$this->fileCategoryValidate->scene('update')->check($param)) {
            return $this->err($this->fileCategoryValidate->getError());
        }

        // 检查下是否重复
        if ($this->fileCategory->duplicate($param['name'], $param['code'], $param['id'])) {
            return $this->err('名称/code已存在');
        }

        $this->fileCategory->update($param);

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
        $check = $this->fileCategory->selectedCount($ids);
        if (!$check) {
            return $this->err('分类选择错误');
        }

        // 删除前判断
        $hasProduct = $this->fileCategory->hasFileInCategory($ids);
        if ($hasProduct) {
            return $this->err('请先删除分类下的分类信息');
        }

        $this->fileCategory->delete($ids);

        return $this->suc();
    }
}
