<?php

namespace app\admin\service;

use app\admin\repository\ActionLogRepository;

class ActionLogService extends BaseService
{
    protected ActionLogRepository $actionLog;

    public function __construct()
    {
        $this->actionLog = new ActionLogRepository();
    }

    // 列表
    public function index($keyword = '', $userID = 0, $page = 1, $perPage = 20)
    {
        return $this->actionLog->index($keyword, $userID, $page, $perPage);
    }

    // 详情
    public function info($id)
    {
        $info = $this->actionLog->info($id);
        if (!$info) {
            return [];
        }
        return $info->toArray();
    }
}
