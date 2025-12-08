<?php

namespace app\admin\controller;

use app\admin\service\PageService;
use think\App;
use think\facade\View;

class Page extends Base
{
    protected PageService $page;

    public function __construct(App $app)
    {
        $this->page = new PageService();
        return parent::__construct($app);
    }

    public function aboutUsHtml()
    {
        return View::fetch('admin@page/aboutus');
    }

    public function privacyHtml()
    {
        return View::fetch('admin@page/privacy');
    }
}
