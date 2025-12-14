<?php

namespace app\admin\controller;

use app\admin\service\FileCategoryService;
use app\admin\validate\FileCategoryValidate;
use think\App;
use think\facade\View;

class FileCategory extends Base
{
    protected FileCategoryService $fileCategory;
    protected FileCategoryValidate $fileCategoryValidate;

    public function __construct(App $app)
    {
        $this->fileCategory = new FileCategoryService();
        $this->fileCategoryValidate = new FileCategoryValidate();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@filecategory/index');
    }
}
