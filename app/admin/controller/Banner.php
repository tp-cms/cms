<?php

namespace app\admin\controller;

use app\admin\service\BannerService;
use app\admin\validate\BannerValidate;
use think\App;
use think\facade\View;

class Banner extends Base
{
    protected BannerService $banner;
    protected BannerValidate $bannerValidate;

    public function __construct(App $app)
    {
        $this->banner = new BannerService();
        $this->bannerValidate = new BannerValidate();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@banner/index');
    }
}
