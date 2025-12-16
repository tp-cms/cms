<?php

namespace app\admin\controller;

use app\admin\service\ConfigService;
use app\admin\service\FileCategoryService;
use app\admin\validate\ConfigValidate;
use think\App;
use think\facade\View;

class Config extends Base
{
    protected ConfigService $config;
    protected FileCategoryService $fileCategory;
    protected ConfigValidate $configValidate;

    public function __construct(App $app)
    {
        $this->config = new ConfigService();
        $this->fileCategory = new FileCategoryService();
        $this->configValidate = new ConfigValidate();
        return parent::__construct($app);
    }

    // 列表
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

    // 保存
    public function save()
    {
        $param = input();
        if (!$this->configValidate->check($param)) {
            return $this->err($this->configValidate->getError());
        }
        $this->config->save($param);
        return $this->suc();
    }
}
