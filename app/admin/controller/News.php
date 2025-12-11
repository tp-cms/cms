<?php

namespace app\admin\controller;

use app\admin\service\NewsService;
use think\App;
use think\facade\View;

class News extends Base
{
    protected NewsService $news;

    public function __construct(App $app)
    {
        $this->news = new NewsService();
        return parent::__construct($app);
    }

    // 列表页面
    public function indexHtml()
    {
        return View::fetch('admin@news/index');
    }
}
