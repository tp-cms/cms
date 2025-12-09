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

    public function aboutUsHtml()
    {
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        // 获取关于我们信息
        $info = $this->page->info('about_us');
        View::assign('info', $info);
        return View::fetch('admin@page/aboutus');
    }

    public function privacyHtml()
    {
        return View::fetch('admin@page/privacy');
    }
}
