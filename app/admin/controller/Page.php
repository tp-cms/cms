<?php

namespace app\admin\controller;

use app\admin\service\FileCategoryService;
use app\admin\service\PageService;
use think\App;
use think\facade\View;

class Page extends Base
{
    protected PageService $page;
    protected FileCategoryService $fileCategory;

    public function __construct(App $app)
    {
        $this->page = new PageService();
        $this->fileCategory = new FileCategoryService();
        return parent::__construct($app);
    }

    // 关于我们
    public function aboutUsHtml()
    {
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        // 获取关于我们信息
        $info = $this->page->info('about_us');
        return View::fetch('admin@page/aboutus');
    }

    // 隐私政策
    public function privacyHtml()
    {
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        // 获取关于我们信息
        $info = $this->page->info('privacy');
        return View::fetch('admin@page/privacy');
    }

    // 保存
    public function save()
    {
        $category = input('post.category');
        if (!$this->page->checkCategory($category)) {
            return $this->err('单页类型不存在');
        }

        $content = input('post.content', '');
        $summary = input('post.summary', '');
        $image = input('post.image', 0);
        $data = [
            'content' => $content,
            'summary' => $summary,
            'image' => $image
        ];

        $this->page->save($data, $category);
        return $this->suc();
    }
}
