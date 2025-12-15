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

    // 列表
    public function indexHtml()
    {
        return View::fetch('admin@actionlog/index');
    }

    public function index()
    {
        $keyword = input('post.keyword', '');
        $page = input('post.page', 1);
        $userId = input('post.user_id', 0);

        if (strlen($keyword) > 26) {
            return $this->err('搜索内容不可超出26个字符');
        }

        $list = $this->actionLog->index($keyword, $userId, $page);
        return $this->suc($list);
    }
}
