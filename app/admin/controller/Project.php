<?php

namespace app\admin\controller;

use app\admin\service\ProjectService;
use think\App;
use think\facade\View;

class Project extends Base
{
    protected ProjectService $project;

    public function __construct(App $app)
    {
        $this->project = new ProjectService();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@project/index');
    }
}
