<?php

namespace app\admin\controller;

use app\admin\service\BannerService;
use app\admin\service\FileCategoryService;
use app\admin\validate\BannerValidate;
use think\App;
use think\facade\View;

class Banner extends Base
{
    protected BannerService $banner;
    protected BannerValidate $bannerValidate;
    protected FileCategoryService $fileCategory;

    public function __construct(App $app)
    {
        $this->banner = new BannerService();
        $this->bannerValidate = new BannerValidate();
        $this->fileCategory = new FileCategoryService();
        return parent::__construct($app);
    }

    // 列表
    public function indexHtml()
    {
        return View::fetch('admin@banner/index');
    }

    public function index()
    {
        $keyword = input('post.keyword', '');
        $page = input('post.page', 1);
        $category = input('post.category', '');

        if (strlen($keyword) > 26) {
            return $this->err('搜索内容不可超出26个字符');
        }

        $list = $this->banner->index($keyword, $category, $page);
        return $this->suc($list);
    }

    // 添加
    public function createHtml()
    {
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        return View::fetch('admin@banner/create');
    }

    public function create()
    {
        $param = $this->request->post();
        if (!$this->bannerValidate->scene('create')->check($param)) {
            return $this->err($this->bannerValidate->getError());
        }

        $userID = $this->request->user['id'];
        $id = $this->banner->create($param, $userID);
        if (!$id) {
            return $this->err('保存失败');
        }

        return $this->suc();
    }

    // 更新
    public function updateHtml()
    {
        $id = $this->request->route('id');
        $info = $this->banner->info($id);
        if (!$info) {
            return View::fetch('admin@tips/notfound');
        }
        View::assign('info', $info);
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        return View::fetch('admin@banner/update');
    }

    public function update()
    {
        $param = $this->request->post();
        if (!$this->bannerValidate->scene('update')->check($param)) {
            return $this->err($this->bannerValidate->getError());
        }

        $this->banner->update($param);

        return $this->suc();
    }

    // 删除
    public function delete()
    {
        $ids = input('post.ids', []);
        if (!$ids && !is_array($ids)) {
            return $this->err('未选择要删除轮播图');
        }

        // 是否选择正确
        $check = $this->banner->selectedCount($ids);
        if (!$check) {
            return $this->err('轮播图选择错误');
        }

        $this->banner->delete($ids);

        return $this->suc();
    }
}
