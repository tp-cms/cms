<?php

namespace app\admin\controller;

use app\admin\service\ConfigService;
use think\App;
use think\facade\View;

class Config extends Base
{
    protected ConfigService $config;

    public function __construct(App $app)
    {
        $this->config = new ConfigService();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@config/index');
    }
}
