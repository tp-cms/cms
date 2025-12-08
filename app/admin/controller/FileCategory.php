<?php

namespace app\admin\controller;

use app\admin\service\FileCategoryService;
use think\App;
use think\facade\View;

class FileCategory extends Base
{
    protected FileCategoryService $fileCategory;

    public function __construct(App $app)
    {
        $this->fileCategory = new FileCategoryService();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@filecategory/index');
    }
}
