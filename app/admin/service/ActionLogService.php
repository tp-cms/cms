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
}
