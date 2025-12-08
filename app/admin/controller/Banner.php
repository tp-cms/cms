<?php

namespace app\admin\controller;

use app\admin\service\BannerService;
use think\App;
use think\facade\View;

class Banner extends Base
{
    protected BannerService $banner;

    public function __construct(App $app)
    {
        $this->banner = new BannerService();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@banner/index');
    }
}