<?php

namespace app\admin\controller;

use app\admin\service\ActionLogService;
use think\App;
use think\facade\View;

class ActionLog extends Base
{
    protected ActionLogService $actionLog;

    public function __construct(App $app)
    {
        $this->actionLog = new ActionLogService();
        return parent::__construct($app);
    }

    public function indexHtml()
    {
        return View::fetch('admin@actionlog/index');
    }
}
