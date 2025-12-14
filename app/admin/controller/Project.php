<?php

namespace app\admin\controller;

use app\admin\service\ProjectService;
use app\admin\validate\ProjectValidate;
use think\App;
use think\facade\View;

class Project extends Base
{
    protected ProjectService $project;
    protected ProjectValidate $projectValidate;

    public function __construct(App $app)
    {
        $this->project = new ProjectService();
        $this->projectValidate = new ProjectValidate();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@project/index');
    }
}
