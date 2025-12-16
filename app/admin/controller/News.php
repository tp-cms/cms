<?php

namespace app\admin\controller;

use app\admin\service\FileCategoryService;
use app\admin\service\NewsService;
use app\admin\validate\NewsValidate;
use think\App;
use think\facade\View;

class News extends Base
{
    protected NewsService $news;
    protected NewsValidate $newsValidate;
    protected FileCategoryService $fileCategory;

    public function __construct(App $app)
    {
        $this->news = new NewsService();
        $this->newsValidate = new NewsValidate();
        $this->fileCategory = new FileCategoryService();
        return parent::__construct($app);
    }

    // 列表
    public function indexHtml()
    {
        return View::fetch('admin@news/index');
    }

    public function index()
    {
        $keyword = input('post.keyword', '');
        $page = input('post.p', 1);
        if (strlen($keyword) > 26) {
            return $this->err('搜索内容不可超出26个字符');
        }

        $list = $this->news->index($keyword, $page);
        return $this->suc($list);
    }

    // 添加
    public function createHtml()
    {
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        return View::fetch('admin@news/create');
    }

    public function create()
    {
        $param = $this->request->post();
        if (!$this->newsValidate->scene('create')->check($param)) {
            return $this->err($this->newsValidate->getError());
        }

        $userID = $this->request->user['id'];
        $id = $this->news->create($param, $userID);
        if (!$id) {
            return $this->err('新增失败');
        }

        return $this->suc();
    }

    // 更新
    public function updateHtml()
    {
        $id = $this->request->route('id');
        $info = $this->news->info($id);
        if (!$info) {
            return View::fetch('admin@tips/notfound');
        }
        View::assign('info', $info);
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        return View::fetch('admin@news/update');
    }

    public function update()
    {
        $param = $this->request->post();
        if (!$this->newsValidate->scene('update')->check($param)) {
            return $this->err($this->newsValidate->getError());
        }

        $this->news->update($param);

        return $this->suc();
    }

    // 删除
    public function delete()
    {
        $ids = input('post.ids', []);
        if (!$ids && !is_array($ids)) {
            return $this->err('未选择要删除新闻');
        }

        // 是否选择正确
        $check = $this->news->selectedCount($ids);
        if (!$check) {
            return $this->err('新闻选择错误');
        }

        $this->news->delete($ids);

        return $this->suc();
    }
}
