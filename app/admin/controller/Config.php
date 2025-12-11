<?php

namespace app\admin\controller;

use app\admin\service\ConfigService;
use app\admin\service\FileCategoryService;
use think\App;
use think\facade\View;

class Config extends Base
{
    protected ConfigService $config;
    protected FileCategoryService $fileCategory;

    public function __construct(App $app)
    {
        $this->config = new ConfigService();
        $this->fileCategory = new FileCategoryService();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        // 配置项
        $configs = $this->config->index();
        View::assign('configs', $configs);
        // 文件分类
        $fileCategory = $this->fileCategory->all();
        View::assign('fileCategory', $fileCategory);
        return View::fetch('admin@config/index');
    }
}
