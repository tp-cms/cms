<?php

namespace app\admin\controller;

use app\admin\service\FileCategoryService;
use app\admin\service\ProjectService;
use app\admin\validate\ProjectValidate;
use PDO;
use think\App;
use think\facade\View;

class Project extends Base
{
    protected ProjectService $project;
    protected ProjectValidate $projectValidate;
    protected FileCategoryService $fileCategory;

    public function __construct(App $app)
    {
        $this->project = new ProjectService();
        $this->projectValidate = new ProjectValidate();
        $this->fileCategory = new FileCategoryService();
        return parent::__construct($app);
    }

    // 列表
    public function indexHtml()
    {
        return View::fetch('admin@project/index');
    }

    public function index()
    {
        $keyword = input('post.keyword', '');
        $page = input('post.p', 1);
        if (strlen($keyword) > 26) {
            return $this->err('搜索内容不可超出26个字符');
        }

        $list = $this->project->index($keyword, $page);
        return $this->suc($list);
    }

    // 新增
    public function createHtml()
    {
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        return View::fetch('admin@project/create');
    }

    public function create()
    {
        $param = $this->request->post();
        if (!$this->projectValidate->scene('create')->check($param)) {
            return $this->err($this->projectValidate->getError());
        }

        $userID = $this->request->user['id'];
        $id = $this->project->create($param, $userID);
        if (!$id) {
            return $this->err('新增失败');
        }

        return $this->suc();
    }

    // 更新
    public function updateHtml()
    {
        $id = $this->request->route('id');
        $info = $this->project->info($id);
        View::assign('info', $info);
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);

        return View::fetch('admin@project/update');
    }

    public function update()
    {
        $param = $this->request->post();
        if (!$this->projectValidate->scene('update')->check($param)) {
            return $this->err($this->projectValidate->getError());
        }

        $this->project->update($param);

        return $this->suc();
    }

    // 删除
    public function delete()
    {
        $ids = input('post.ids', []);
        if (!$ids && !is_array($ids)) {
            return $this->err('未选择要删除案例');
        }

        // 是否选择正确
        $check = $this->project->checkSelect($ids);
        if (!$check) {
            return $this->err('案例选择错误');
        }

        $this->project->delete($ids);

        return $this->suc();
    }
}
